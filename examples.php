<?php

// Require library
require_once('travel_time_lib.php');

// Add in API id and key settings
$travelTime = new Travel_time_lib('id-here', 'key-here', TRUE);

// Time filter example
$params = array(
	'origin'      => array(51.5016,-0.1080),
	'travel_time' => 3600,
	'properties'  => array('time'),
	'modes'       => array('walking_train'),
	'start_time'  => date('c'),
	'accuracy'    => 'approx',
	'points'      => array(
		'one'   => array(51.5132, -0.2095),
		'two'   => array(51.45724240269379,-0.20781299521490837),
		'three' => array(51.54328,-0.02568)
	)
);

$time_filter = $travelTime->time_filter($params);

// Time map example
$params = array(
	'origin'      => array(51.5016,-0.1080),
	'travel_time' => 3600,
	'mode'        => 'walking_train',
	'start_time'  => date('c'),
	'smooth'      => true,
	'accuracy'    => "approx",
);

$time_map = $travelTime->time_map($params);

// Routes example
$params = array(
	'origin'      => array(51.5016,-0.1080),
	'travel_time' => 3600,
	'properties'  => array('time'),
	'mode'        => 'walking_train',
	'start_time'  => date('c'),
	'accuracy'    => "approx",
	'points'      => array(
		'one'   => array(51.5132, -0.2095),
	)
);

$routes = $travelTime->routes($params);

// Geocode postcodes example
$params = array('GU2 7YG', 'GU2 7NG');
$geocode_postcodes = $travelTime->geocode_postcodes($params);

var_dump($time_filter);
var_dump($time_map);
var_dump($routes);
var_dump($geocode_postcodes);