<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use \lithium\net\http\Router;

// Route for reading a blog post (note the "document_type" parameter)
Router::connect('/blog/read/{:url}', array('library' => 'minerva', 'plugin' => 'minerva_blog', 'controller' => 'pages', 'action' => 'read'));

// Route for listing all blog entries
Router::connect('/blog/index', array('library' => 'minerva', 'plugin' => 'minerva_blog', 'controller' => 'pages', 'action' => 'index'));
// Pagination for blog entries (default limit is 10)
Router::connect('/blog/index/page:{:page:[0-9]+}', array('library' => 'minerva', 'plugin' => 'minerva_blog', 'controller' => 'pages', 'action' => 'index'));
Router::connect('/blog/index/page:{:page:[0-9]+}/limit:{:limit:[0-9]+}', array('library' => 'minerva', 'plugin' => 'minerva_blog', 'controller' => 'pages', 'action' => 'index'));

// Yes, you can render "static" pages from the library as well by using the "view" action,
// Templates from: /libraries/minerva_blog/views/pages/static/template-name.html.php
Router::connect('/blog', array('library' => 'minerva', 'plugin' => 'minerva_blog', 'controller' => 'pages', 'action' => 'view', 'home'));
Router::connect('/blog/view/{:args}', array('library' => 'minerva', 'plugin' => 'minerva_blog', 'controller' => 'pages', 'action' => 'view', 'home'));

// NOTE: /blog route could also be reached via the default Minerva route: /minerva/plugin/minerva_blog
// Also: /minerva/plugin/minerva_blog/pages/read/document == /blog/read/{:url}

Router::connect('/comments/{:action}.json', array('library' => 'minerva_blog', 'controller' => 'comments', 'type' => 'json'));
Router::connect('/comments/{:action}/{:args}.json', array('library' => 'minerva_blog', 'controller' => 'comments', 'type' => 'json'));
?>