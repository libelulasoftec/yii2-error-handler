<?php

namespace taguz91\ErrorHandler\models;

use taguz91\CommonHelpers\Utils;
use yii\mongodb\ActiveRecord;

class Exceptions extends ActiveRecord
{

  /**
   * @inheritdoc
   */
  public static function collectionName()
  {
    return 'exceptions';
  }

  /**
   * @inheritdoc
   */
  public function attributes()
  {
    return [
      '_id',
      'empCodigo',
      'createdAt',
      'date',
      'exception',
      'response'
    ];
  }

  /**
   * @param (array|mixed)[] $response
   */
  static function store(
    string $empCodigo,
    string $exception,
    array $response
  ): void {
    $exc = new Exceptions();
    $exc->empCodigo = $empCodigo;
    $exc->createdAt = Utils::getNowMongo();
    $exc->date = Utils::getNow();
    $exc->exception = $exception;
    $exc->response = $response;
    $exc->save();
  }
}
