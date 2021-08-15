<?php

namespace taguz91\ErrorHandler\models;

use taguz91\CommonHelpers\Utils;
use Yii;
use yii\mongodb\ActiveRecord;

/**
 * 
 * @property \MongoDB\BSON\UTCDateTime $createdAt
 * @property string $date
 * @property string $exception
 * @property array $response
 * @property string $empCodigo
 * @property string $currentUrl
 * @property <string, string> $user
 * @property string $method
 */
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
      'response',
      'currentUrl',
      'user',
      'method',
    ];
  }

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [$this->attributes(), 'safe']
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

    // Save the request information 
    $request = Yii::$app->request;

    $exc->currentUrl = $request->absoluteUrl;
    $exc->user = [
      '_id' => Yii::$app->user->identity->_id ?? null,
      'ip' => $request->userIP,
      'host' => $request->userHost,
      'agent' => $request->userAgent,
    ];
    $exc->method = $request->getMethod();

    $exc->save();
  }
}
