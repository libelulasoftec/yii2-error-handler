<?php

namespace Libelulasoft\ErrorHandler;

use taguz91\ErrorHandler\exceptions\MessageException;
use taguz91\ErrorHandler\utils\Handler;
use Yii;
use yii\web\ErrorHandler as WebErrorHandler;

/**
 * 
 */
class ErrorHandler extends WebErrorHandler
{

  /** @var \taguz91\ErrorHandler\utils\Handler */
  public $handler;

  /** @var string */
  public $empresa;

  /** @var string[] Classname for exception to not save */
  public $exceptionsNotSave = [
    MessageException::class,
  ];

  /** @var bool */
  public $saveError = false;

  /** @var bool */
  public $showTrace = YII_DEBUG;

  public function init()
  {
    parent::init();
    if ($this->handler === null) {
      $this->handler = new Handler($this->empresa);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function convertExceptionToArray($exception)
  {
    if ($exception === null) {
      return [
        'transaccion' => false,
        'errorDescripcion' => Yii::t('app', 'Error not found.'),
      ];
    }

    $saveError = $this->saveError;
    if (in_array(get_class($exception), $this->exceptionsNotSave)) {
      $saveError = false;
    }

    return $this->handler->get(
      $exception,
      $saveError,
      $this->showTrace
    );
  }
}
