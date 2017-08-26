<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\SignupForm;
use api\models\LoginForm;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
                'optional' => [// 排除不需要认证的动作
                    'login',
                    'signup',
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
        $model->setAttributes(Yii::$app->request->post());
        if ($user = $model->login()) {
            return [
                'code' => 1,
                'msg' => '登录成功',
                'token' => $user->access_token,
            ];
        } else {
            return $this->errorMessage($model);
        }
    }

    /**
     * 用户资料
     * @return array
     */
    public function actionGetProfile()
    {
        $user = Yii::$app->user->identity;

        return [
            'code' => 1,
            'username' => $user->username,
            'email' => $user->email,
        ];
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
