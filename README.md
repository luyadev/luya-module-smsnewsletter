# LUYA SMS Newsletter module with ASPSMS

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-module-smsnewsletter/downloads)](https://packagist.org/packages/luyadev/luya-module-smsnewsletter)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-module-smsnewsletter/v/stable)](https://packagist.org/packages/luyadev/luya-module-smsnewsletter)

Add persons, add lists, send SMS messages to the persons in the list. Including the delivery status for every message.

## Installation

Install the extension through composer:

```sh
composer require luyadev/luya-module-smsnewsletter
```

Configure the module in the config:

```php
'modules' => [
    // ...
    'smsnewsletteradmin' => [
        'class' => 'luya\smsnewsletter\admin\Module',
        'originName' => 'My Sender Name',
        'defaultNumberRegion' => 'ch',
        'aspsmsKey' => '****', // see aspsms.com
        'aspsmsPassword' => '****', // see aspsms.com
    ],
    // ...
],
```

Run the migrate command:

```sh
./luya migrate
```

Run the import command afterwards:

```sh
./luya import
```