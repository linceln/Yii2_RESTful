<?php

namespace api\modules\v1\controllers;

use common\models\User;
use Yii;
use common\models\SignupForm;
use api\modules\v1\models\LoginForm;
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
                    'signup',
                    'test'
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
        if ($model->signup()) {
            return [
                'code' => 1,
                'msg' => '注册成功',
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
        $model->setAttributes(Yii::$app->request->get());
        if ($auth = $model->login()) {
            $user = User::findById($auth->user_id);
            return [
                'code' => 1,
                'msg' => '登录成功',
                'accessToken' => $auth->access_token,
                'username' => $user->username,
                'mobile' => $user->mobile,
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
