<?php

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\User;
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
        if ($model->load(Yii::$app->request->post(), '') && $user = $model->signup()) {
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
        if ($model->load(Yii::$app->request->post(), '') && $auth = $model->login()) {
            return [
                'code' => 1,
                'msg' => '登录成功',
                'token' => $auth->access_token,
                'username' => $auth->user->username,
                'mobile' => $auth->user->mobile,
            ];
        }
        return $this->errorMessage($model);
    }

    /**
     * 获取全部用户的信息
     * @param $page integer
     * @return array
     */
    public function actionIndex($page)
    {
        $dataProvider = User::index($page);
        var_dump($dataProvider->models[0]);
        die;
//        foreach ($dataProvider->models as $key => $value) {
//            var_dump('~~~~~~~~~~start~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');
//            var_dump($key);
//            var_dump($value);
//            var_dump('~~~~~~~~~~end~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');
//        }
//        die;
        return [
            'code' => 1,
            'pages' => $dataProvider->pagination->pageCount,
            'users' => $dataProvider->models[0],
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
            'msg' => current($model->firstErrors),
        ];
    }
}