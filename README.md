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