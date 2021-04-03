Error handler
=============
Error handler for mongo database

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist taguz91/yii2-error-handler
```

or add

```
"taguz91/yii2-error-handler": "~1.0.0"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
// confing\main.php

'components' => [
  ...,
  'errorHandler' => [
    'taguz91\ErrorHandler\ErrorHandler',
    'errorAction' => 'site/error',
    'empresa' => 'UNIQUE CODE',
    'saveError' => true,
  ],
]
```