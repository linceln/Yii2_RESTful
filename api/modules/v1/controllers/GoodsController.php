<?php

namespace api\modules\v1\controllers;

use api\models\Goods;
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

    public function actionCreate()
    {

    }

    public function actionGetValidGoods()
    {
        $validGoods = Goods::find()
            ->select(['id', 'name'])
            ->where(['!=', 'name', ''])
            ->asArray()
            ->all();
        return [
            'code' => 1,
            'message' => '请求成功',
            'goods' => $validGoods
        ];
    }

    /**
     * @field Goods
     * @return array
     */
    public function actionFill()
    {
        $goods = Goods::find()->select(['id', 'name'])->where(['name' => ''])->all();
        $result = [];
        foreach ($goods as $k => $good) {
            $good->name = 'good';
            if ($good->save()) {
                $result[$k]['id'] = $good->id;
                $result[$k]['name'] = $good->name;
            } else {
                $result[$k]['id'] = $good->id;
                $result[$k]['name'] = 'Not save';
            }
        }

        return [
            'code' => 1,
            'result' => $result
        ];
    }
}
