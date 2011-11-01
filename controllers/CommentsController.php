<?php
namespace minerva_blog\controllers;

use \lithium\util\Set;
use \lithium\util\String;

use lithium\analysis\Logger;

use minerva_blog\models\Comment;
use minerva\models\Page;
use \lithium\security\Auth;
use \lithium\util\Validator;
use \MongoDate;

class CommentsController extends \lithium\action\Controller {
	
	/**
	 * Post a comment for a given page.
	 * This method must accessed with a JSON POST request.
	 *
	 * @param string $page_id The page id
	 * @return string JSON response
	*/
	public function create($page_id=null) {
		// Set the response to return
		$response = array('success' => true);
		
		// If there was no page id provided
		if(empty($page_id)) {
			$response['success'] = false;
		}
		
		// Check to ensure that JSON was used to make the POST request
		if(!$this->request->is('json')) {
			$response['success'] = false;
		}
		
		if($response['success'] === true) {		
			$user = Auth::check('minerva_user');

			// If data was passed, set some more data and save
			if ($this->request->data) {
				// Gather the data in $data and $comment array
				$data['_page_id'] = $page_id;

				// IMPORTANT: Use MongoDate() when inside an array/object because $_schema isn't deep
				$now = new MongoDate();
				$comment = array(
					'created' => $now,
					'modified' => $now,
					'body' => $this->request->data['body'],
					'approved' => false
				);

				// The user is going to be logged in, or they can be anonymous, but they must provide their name and e-mail
				if(isset($user['_id'])) {
					$comment['_user_id'] = $user['_id'];
					$comment['email'] = $user['email'];
					$comment['name'] = $user['first_name'] . ' ' . $user['last_name'];
				} else {
					$comment['_user_id'] = null;
					$comment['name'] = $this->request->data['name'];
					$comment['email'] = $this->request->data['email'];
				}

				// Grab the user's IP too (should work on RackSpace Cloud Load Balancers over HTTP and HTTPS and many other LBs)
				$comment['ip'] = (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) ? $_SERVER['HTTP_X_CLUSTER_CLIENT_IP']:null;
				$comment['ip'] = (empty($comment['ip']) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR']:$comment['ip'];
				$comment['ip'] = (empty($comment['ip']) && isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR']:$comment['ip'];

				// Set the comments field to the comment, this will be used if saving a new thread
				$data['comments'][0] = $comment;

				// $comment Validation
				$rules = array(
					'name' => 'You must provide your name.',
					'email' => array(
						array('notEmpty', 'message' => 'You must provide your e-mail address.'),
						array('email', 'message' => 'Your e-mail address is not valid.')
					),
					'body' => array(
						array('notEmpty', 'message' => 'You must provide a comment.'),
						array('lengthBetween', 'min' => 0, 'max' => 600, 'message' => 'Your comment must be shorter than 600 characters.')
					)
				);
				$errors = Validator::check($comment, $rules);
				if(!empty($errors)) {
					$response['success'] = false;
					$response['errors'] = $errors;
					return json_encode($response);
				}

				// See if there's already a comment thread for this page id, otherwise make a new document.
				$existing_thread = Comment::find('first', array('conditions' => array('_page_id' => $page_id)));
				if(!empty($existing_thread)) {
					// Update the existing comment thread
					$response['success'] = Comment::update(
						array(
							'$push' => array(
								'comments' => $comment
							)
						),
						array('_page_id' => $page_id),
						array('atomic' => false)
					);

				} else {				
					// Save the new comment thread
					$document = Comment::create();
					$response['success'] = $document->save($data);
				}
			}
		}
		
		$this->render(array('json' => $response));
	}
	
	/**
	 * Read comments thread for a given page.
	 * 
	 * @param string $page_id The page id
	 * @return string Comments in JSON format
	*/
	public function thread($page_id=null) {
		if(empty($page_id)) {
			return null;
		}
		
		$comments = Comment::find('first', array('conditions' => array('_page_id' => $page_id)));
		
		// Only allow this action to be viewed as JSON
		if($this->request->is('json')) {
			return $comments->data();
		} else {
			$this->redirect('/blog');
		}
	}
	
}
?>