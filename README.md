Error handler
=============
Error handler for mongo database

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist libelulasoft/yii2-error-handler
```

or add

```
"libelulasoft/yii2-error-handler": "~1.0.0"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by:

```php
// confing\main.php

'components' => [
  ...,
  'errorHandler' => [
    'errorAction' => 'site/error',
    'class' => \Libelulasoft\ErrorHandler\ErrorHandler::class,
    'empresa' => $_GET['empresa'] ?? 'undefined',
    'bdConnection' => 'mongodb',
    'saveError' => true,
    'showTrace' => YII_DEBUG,
    'saveBody' => YII_DEBUG,
    // This exceptions not be save into database
    'exceptionsNotSave' => [
      \Libelulasoft\ErrorHandler\exceptions\MessageException::class
    ],
  ],
]
```