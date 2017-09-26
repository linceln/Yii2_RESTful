<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\SignupForm;
use common\models\LoginForm;
use yii\base\Model;
use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;

class UserController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
                'optional' => [// 排除不需要认证的动作
                    'login',
                    'signup'
                ]
            ]
        ]);
    }

    /**
     * 注册
     * @return array
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $model->setAttributes(Yii::$app->request->post());
        if ($user = $model->signup()) {
            return [
                'code' => 1,
                'msg' => '注册成功，快去登录吧～',
                'username' => $user->username,
                'mobile' => $user->mobile,
            ];
        } else {
            return $this->errorMessage($model);
        }
    }

    /**
     * 登录
     * @return array
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->get(), '') && $model->validate()) {
            $auth = $model->login();
            return [
                'code' => 1,
                'msg' => '登录成功',
                'token' => $auth->access_token,
                'username' => $auth->user->username,
                'mobile' => $auth->user->mobile,
                'device_id' => $auth->device->id,
                'device_name' => $auth->device->name,
                'bmi' => $auth->user->bmi ?: 0,
            ];
        }
        return $this->errorMessage($model);
    }

    /**
     * @param $model Model
     * @return array
     */
    private function errorMessage($model)
    {
        return [
            'code' => 0,
            'msg' => current($model->getFirstErrors()),
        ];
    }
}
