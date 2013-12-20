<?php
Router::connect('/support', array(
	'plugin' => 'support_ticket', 
	'controller' => 'tickets', 
	'action' => 'index'
));

Router::connect('/support/ticket/:id/:slug', array(
	'plugin' => 'support_ticket', 
	'controller' => 'tickets', 
	'action' => 'view',
	'id' => '*',
	'slug' => '*'
));

$routes = array(
	'support_ticket_index' => array(
		'route' => array(
			'plugin' => 'support_ticket',
			'controller' => 'tickets',
			'action' => 'index'
		)
	),
	'support_ticket_add' => array(
		'route' => array(
			'plugin' => 'support_ticket',
			'controller' => 'tickets',
			'action' => 'add'
		)
	),
	'support_ticket_view' => array(
		'route' => array(
			'plugin' => 'support_ticket',
			'controller' => 'tickets',
			'action' => 'view'
		),
		'params' => array(
			'id',
			'slug'
		),
		'key' => 'Ticket'
	)
);
$routes = array_merge_recursive(Configure::read('current_routes'), $routes);
Configure::write('current_routes', $routes);