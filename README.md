# iGeolise Travel Time Library

This class is to enable you to interact with the iGeolise Travel Time API.

https://igeolise.3scale.net/

## Usage

You need to pass two parameters to the class:

- Your API ID
- Your API Key
- Turn debug output on/off [optional]

```php
$travelTime = new Travel_time_lib('id','key',TRUE);
```

If the debug mode is set to TRUE then extra information will be included in the returned array.

## Examples

Taken from https://igeolise.3scale.net/examples

### Filter points by time

```php
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
```

### Get points for a travel time map

```php
$params = array(
    'origin'      => array(51.5016,-0.1080),
	'travel_time' => 3600,
	'mode'        => 'walking_train',
	'start_time'  => date('c'),
	'smooth'      => true,
	'accuracy'    => "approx",
);

$time_map = $travelTime->time_map($params);
```

### Get a route to a destination

```php
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
```

### Geocode postcodes

```php
$params = array('GU2 7YG', 'GU2 7NG');
$geocode_postcodes = $travelTime->geocode_postcodes($params);
```
