<?php

namespace taguz91\ErrorHandler;

use taguz91\ErrorHandler\utils\Handler;
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

  /** @var bool */
  public $saveError = false;

  public function init()
  {
    parent::init();
    if ($this->handler === null) {
      $this->handler = new Handler($this->exception, $this->empresa);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function convertExceptionToArray($exception)
  {
    return $this->handler->get($this->saveError);
  }
}
