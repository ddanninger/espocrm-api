# espocrm-api

## Installation

The Package is available on Packagist ([ddanninger/espocrm-api](https://packagist.org/packages/ddanninger/espocrm-api))
and as such installable via [Composer](http://getcomposer.org/).

If you do not use Composer, you can grab the code from GitHub, and use any PSR-4 compatible autoloader
(e.g. the [Symfony ClassLoader component](https://github.com/symfony/ClassLoader)) to load the library's classes.

### Composer example

Add espocrm-api in your composer.json:

```js
{
    "require": {
        "ddanninger/espocrm-api": "dev-master"
    }
}
```

Download the library:

``` bash
$ php composer.phar update ddanninger/espocrm-api
```

After installing, you need to require Composer's autoloader somewhere in your code:

```php
require_once 'vendor/autoload.php';
```

## Usage

```php
use EspoCRM\Api\Client\EspoClient;

$client = EspoClient::factory([
    'url'     => 'http://plus.dev/',     // required
    'username' => 'admin', // required
    'token' => 'admin' // required
]);


$command = $client->getCommand('list', [
    'entityType' => 'Account',
    'maxSize'  => 10
]);

$results = (array) $client->execute($command); // returns an array of results
```

You can find a list of the client's available commands in the bundle's
[client.json](https://github.com/ddanninger/espocrm-api/blob/master/src/Resources/config/v1/client.json) or take a look into the api docu of espocrm https://github.com/espocrm/documentation/blob/master/development/api.md.