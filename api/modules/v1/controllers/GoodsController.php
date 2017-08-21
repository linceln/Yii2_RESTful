<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;

class GoodsController extends ActiveController
{
    public $modelClass = 'api\models\Goods';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

            'authenticator' => [
                'class' => HttpBearerAuth::className(),
            ]
        ]);
    }
}
