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

Migration
-----

Si se quiere migrar de la version `taguz91/yii2-error-handler` a la nueva version `libelulasoft/yii2-error-handler` se debe seguir los siguientes pasos: 

1. Seguir la guia de migracion para [yii2-common-helpers](https://github.com/libelulasoftec/yii2-common-helpers).

2. Eliminar la version actual

```
composer remove taguz91/yii2-error-handler
```

3. Instalar la nueva version 

```
composer require libelulasoft/yii2-error-handler
```

4. Se debe cambiar el namespace `taguz01\ErrorHandler` a `Libelulasoft\ErrorHandler` en todo el proyecto.

5. Actualizar las configuraciones de la libreria, agregando las nuevas opciones: 
  1. **bdConnection** nombre de la base de datos que se usara para guardar todas las excepciones.
  2. **saveError** booleano que nos indica si debemos guardar los errores en base de datos.
  3. **showTrace** booleano que nos indica si debemos mostrar le trace en la response, por defecto utiliza la constante YII_DEBUG
  4. **saveBody** booleano que nos indica si debemos guardar los datos enviados por *post* en la excepcion, por defecto se utiliza la constante YII_DEBUG

6. Probamos que todo funcione de forma correcta.

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