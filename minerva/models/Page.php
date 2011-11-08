<?php
/**
 * Minerva Blog Plugin
 * Page Model
 * 
 * This page model extends Minerva's Page model.
 * In fact, it's specific type of model called a Minerva Model.
 * That's why it's also located under the minerva/models directory.
 * 
 * This model must extend \minerva\models\Page in order to hook
 * into the CMS and utilize it's methods.
 * 
 * This model can adjust properties of the core Minerva Page model.
 * For example, it can change access rules, schema, validation, and more.
 * 
 * A controller is not required. However, you could create a PagesController
 * within this plugin, so long as you create the appropriate routes to actually
 * use that controller. Don't forget that you can apply filters from this model 
 * as well that can give you a lot of control over other methods. This is yet
 * another way of hooking into the core CMS without modifying its files.
 * Leaving your copy of the CMS pristine and clean for upgrades.
 * 
 * In addition to this file, templates under this plugin's views directory are
 * required in order to complete the picture.
 * 
*/
namespace minerva_blog\minerva\models;

class Page extends \minerva\models\Page {
	
	// This model's access rules will takey priority over the others, but it's appended to the previous models,
    // so if we didn't specify a rule for 'read' it would be use the default.
    // NOTE: This is NOT recursive. It's only for the top level items (actions) 
    // So if an action key is set here in the access rules, be sure the rules under it are EXACTLY as desired.
    public $access = array(
        'read' => array(
            'action' => array(),
            'admin_action' => array(),
            'document' => array(),
        ),
        'index' => array(
            'action' => array('rule' => 'allowAll'),
             'admin_action' => array(
                array('rule' => 'allowManagers', 'redirect' => array('admin' => 'admin', 'library' => 'minerva', 'controller' => 'users', 'action' => 'login'))
            )
        )
	);
	
	// Add new fields here
	protected $_schema = array(
		// this won't overwrite the main app's page models' $fields title key
		'title' => array(
			'form' => array(
				'label' => 'Blog Title'
			)
		),
		// these are new
		'author' => array(
			'type' => 'string',
			'form' => array(
				'help_text' => 'Optionally override the author name which is set from your user name.',
				'position' => 'options'
			)
		),
		'body' => array(
			'type' => 'string',
			'form' => array(
				'label' => 'Body Copy',
				'type' => 'textarea',
				'class' => 'tinymce'
			)
		)
	);
	
	public $search_schema = array(
		'body' => array(
			'weight' => 1
		)
	);
	
	// If you want to redirect core actions (create, update, and delete)
	// 'self' and 'referer' are special values that redirect to the same URL or to the referring URL
	public $action_redirects = array(
		'update' => 'self'
	);
	
	// Add validation rules for new fields here
	public $validates = array(
		'body' => array(
                    array('notEmpty', 'message' => 'Body cannot be empty'),
                ),
		'title' => array(
		    array('notEmpty', 'message' => 'It can\'t be empty foo!')
		)
	);
	
	// A little context
	public $display_name = 'Blog Entry';
	
	// This can optionally be set in order to avoid conflicting document_type names, which are automatically assigned based on the library name
	//public $document_type = 'blogtest';
	
	// could actualy also change the _meta! so you can store this in another collection, unlock the shcema, etc.
	// no compromise on lithium functionality. not sure one would ever want to do this...but...
	/* 
	protected $_meta = array(
		'locked' => false,
		'source' => 'blogs'
	);
	*/
	
	
	public static function __init() {
		
		\minerva\models\Page::applyFilter('find', function($self, $params, $chain) {
		    
            /**
             * find() doens't do anything with a "request_params" key and you wouldn't typically see it...
             * However, all core Minerva code will pass the request params to all find() calls just for
             * this kind of flexibility. In this case, if it's not an admin action then we're adding to the
             * conditions the requirement of the document being published.
             *
             * Note that this filter is applied to the core Minerva Page model.
             * So as long as this model gets called, it will apply the published condition to all finds
             * for all pages. Keep in mind the order in which filters are applied and when libraries are added.
             * It's probably best to apply this sort of filter as self::applyFilter() instead so that we are
             * more certain of when it's used. The filter can also be defined below outside of the class.
             *
             * What else could we do here? We could say certain users could see it on non-admin actions too...
             * Or...whatever else that could be dreamed of.
            */
            if(!isset($params['options']['request_params']['admin']) || empty($params['options']['request_params']['admin'])) {
				$params['options']['conditions']['published'] = true;
            }
					    
		    return $chain->next($self, $params, $chain);
		    
		    // NOTE: could be applying access rules here and checking against them
		    //$record = $chain->next($self, $params, $chain);
		    // Here would be an "afterFind" don't forget to return $record; instead of to the chain
		    //var_dump($record);
		    
		});
		
		// Put any desired filters here
		
		parent::__init();
	}
	
}

// Apply a filter to Minerva's Access class.
// The Access class will determine if the, already authenticated at this point, user has access to the requested location.
/*Access::applyFilter('check', function($self, $params, $chain) {
        var_dump('filter on check, applied from /libraries/blog/models/Page.php');
	exit();
        return $chain->next($self, $params, $chain);
});*/

/* MODEL FILTERS GO HERE
 *
 * Any filters must be set down here outside the class because of the class extension by libraries.
 * If the filter was applied within __init() it would run more than once.
 *
*/
Page::applyFilter('find', function($self, $params, $chain) {
	$params['options']['order'] = array('created' => 'desc');
	return $chain->next($self, $params, $chain);
});
?>