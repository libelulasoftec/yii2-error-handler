<?php

namespace taguz91\ErrorHandler\utils;

use Exception;
use taguz91\ErrorHandler\models\Exceptions;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class Handler
{

  /** @var Exception */
  private $_exception;

  /** @var integer */
  private $_code;

  /** @var string */
  public $empresa;

  public function __construct(Exception $exception, string $empresa)
  {
    $this->_exception = $exception;
    $this->_code = $exception->getCode();
    $this->empresa = $empresa;
  }

  /**
   * Return de error to store into database
   */
  public function get(bool $saveError): array
  {
    switch ($this->_code) {
      case 401:
        $response = $this->unathorized();
        break;

      default:
        $response = $this->common();
        break;
    }

    if ($saveError) {
      Exceptions::store(
        $this->empresa,
        get_class($this->_exception),
        ArrayHelper::merge($response, [
          'meta' => $this->meta()
        ])
      );
    }

    return $response;
  }

  private function unathorized()
  {
    return [
      'transaccion' => false,
      'errorDescripcion' => Yii::t('app', 'Not authorized for this actions.'),
    ];
  }

  private function common(): array
  {
    return [
      'transaccion' => false,
      'errorDescripción' => $this->_code === 1
        ? $this->_exception->getMessage()
        : Yii::t('app', 'A error ocurrend when process your request.'),
    ];
  }

  private function meta(): array
  {
    $exception = $this->_exception;
    $meta = [
      'exception' => $exception->getMessage(),
      'class' => get_class($exception),
      'file' => $exception->getFile(),
      'line' => $exception->getLine(),
      'trace' => explode("\n", $exception->getTraceAsString())
    ];

    if ($exception instanceof HttpException) {
      $meta['status'] = $exception->statusCode;
    }

    return $meta;
  }
}
