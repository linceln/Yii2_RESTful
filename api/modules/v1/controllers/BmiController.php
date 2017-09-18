<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 16/09/2017
 * Time: 19:36
 */

namespace api\modules\v1\controllers;

use Yii;
use common\models\Bmi;
use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;

class BmiController extends Controller
{
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
        $model = new Bmi();
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return [
                'code' => 1,
                'msg' => '保存成功',
                'bmi' => $model->bmi,
            ];
        } else {
            return [
                'code' => 0,
                'msg' => current($model->getFirstErrors())
            ];
        }
    }
}