Error handler
=============
Error handler for mongo database

[![Latest Stable Version](https://poser.pugx.org/taguz91/yii2-error-handler/v)](//packagist.org/packages/taguz91/yii2-error-handler) 
[![Total Downloads](https://poser.pugx.org/taguz91/yii2-error-handler/downloads)](//packagist.org/packages/taguz91/yii2-error-handler) 
[![Latest Unstable Version](https://poser.pugx.org/taguz91/yii2-error-handler/v/unstable)](//packagist.org/packages/taguz91/yii2-error-handler) 
[![License](https://poser.pugx.org/taguz91/yii2-error-handler/license)](//packagist.org/packages/taguz91/yii2-error-handler)

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

Once the extension is installed, simply use it in your code by:

```php
// confing\main.php

'components' => [
  ...,
  'errorHandler' => [
    'errorAction' => 'site/error',
    'class' => \taguz91\ErrorHandler\ErrorHandler::class,
    'empresa' => $_GET['empresa'] ?? 'undefined',
    'saveError' => true,
    // This exceptions not be save into database
    'exceptionsNotSave' => [
      \taguz91\ErrorHandler\exceptions\MessageException::class
    ],
  ],
]
```