# Szeneaarau Module
 
File has been created with `module/create` command. 
 
## Installation

In order to add the modules to your project go into the modules section of your config:

```php
return [
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
];
```