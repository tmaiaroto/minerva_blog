<?php
/**
 * Minerva Blog Comments Model
 * 
 */
namespace minerva_blog\models;

class Comment extends \lithium\data\Model {
	
	 protected $_schema = array(
		 '_id' => array('type' => 'id'),
		 '_page_id' => array('type' => 'string'),
		 'comments' => array('type' => 'array')
	);
		
	public static function __init() {
		
		\minerva\models\Page::applyFilter('find', function($self, $params, $chain) {
		    
            if((isset($params['options']['request_params']['admin'])) && ($params['options']['request_params']['admin'] !== true)) {
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
?>