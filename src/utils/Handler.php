<?php

namespace Libelulasoft\ErrorHandler\utils;

use Error;
use Exception;
use taguz91\ErrorHandler\exceptions\DataException;
use taguz91\ErrorHandler\exceptions\MetadataException;
use taguz91\ErrorHandler\models\Exceptions;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class Handler
{

  /** @var Exception|Error */
  private $_exception;

  /** @var integer */
  private $_code;

  /** @var string */
  public $empresa;

  public function __construct(string $empresa)
  {
    $this->empresa = $empresa;
  }

  /**
   * @param Exception|Error
   */
  private function init($exception)
  {
    $this->_exception = $exception;
    $this->_code = $exception->getCode();
  }

  /**
   * @param Exception|Error
   * Return de error to store into database
   */
  public function get(
    $exception,
    bool $saveError,
    bool $showTrace = YII_DEBUG
  ): array {
    $this->init($exception);
    switch ($this->_code) {
      case 401:
        $response = $this->unathorized();
        break;

      case 1001:
        $response = $this->message();
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

    // Return with meta data error
    if ($showTrace) {
      return ArrayHelper::merge($response, [
        'meta' => $this->meta()
      ]);
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
    $error = [
      'transaccion' => false,
      'errorDescripcion' => Yii::t('app', 'A error ocurrend when process your request.'),
      'rawError' => $this->_exception->getMessage(),
    ];

    if ($this->_exception instanceof DataException) {
      $error = ArrayHelper::merge($error, $this->_exception->getDataError());
    }

    return $error;
  }

  private function message(): array
  {
    return [
      'transaccion' => false,
      'errorDescripcion' => $this->_exception->getMessage(),
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

    if ($this->_exception instanceof MetadataException) {
      $meta = ArrayHelper::merge($meta, $this->_exception->getMetadataError());
    }

    return $meta;
  }
}
