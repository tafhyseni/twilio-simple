# SMS and Phone Calls by Twilio made easy

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tafhyseni/twilio-simple.svg?style=flat-square)](https://packagist.org/packages/tafhyseni/twilio-simple)
[![Build Status](https://img.shields.io/travis/tafhyseni/twilio-simple/master.svg?style=flat-square)](https://travis-ci.org/tafhyseni/twilio-simple)
[![Quality Score](https://img.shields.io/scrutinizer/g/tafhyseni/twilio-simple.svg?style=flat-square)](https://scrutinizer-ci.com/g/tafhyseni/twilio-simple)
[![Total Downloads](https://img.shields.io/packagist/dt/tafhyseni/twilio-simple.svg?style=flat-square)](https://packagist.org/packages/tafhyseni/twilio-simple)

This is a helper package to help you using Twilio. Sending SMS and making Phone Calls has never been easier!

## Installation

You can install the package via composer:

```bash
composer require tafhyseni/twilio-simple
```

## Usage
Send a SMS to a specified phone number
``` php
use Tafhyseni\TwilioSimple\RequestTwilio;

$twilio = new RequestTwilio(
    'YOUR_twilio_SID',
    'YOUR_twilio_TOKEN',
    'YOUR_twilio_verified_number'
);

$twilio->setSMS('This is my SMS message body');
if(!$twilio->sendSMS('PHONE_NUMBER_HERE'))
{
    // An error happened. 
    echo $twilio->getError(); // getError() will return the error message!
}else{
    // message sent/queued
    echo $twilio->countSMS(); // countSMS() will return the number of sms sent.
}
```
Make a call to a phone number and say something
``` php
use Tafhyseni\TwilioSimple\RequestTwilio;

$twilio = new RequestTwilio(
    'YOUR_twilio_SID',
    'YOUR_twilio_TOKEN',
    'YOUR_twilio_verified_number'
);

$twilio->setSMS('Hello, this call is made from Twilio Simple Package!');
if(!$twilio->makeCall('PHONE_NUMBER_HERE'))
{
    $data['error'] = 'Error:' . $twilio->getError();
}else{
    $data['error'] = 'Call Done!';
}
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email tafhyseni@gmail.com instead of using the issue tracker.

## Credits

- [Mustafe Hyseni](https://github.com/tafhyseni)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
