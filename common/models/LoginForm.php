<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;
use api\modules\v1\models\AuthToken;

/**
 * Api login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $device;

    /**
     * @var User
     */
    private $_user;


    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            'frontend' => ['username', 'password'],
            'api' => ['username', 'password', 'device']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'device'], 'required'],
            ['password', 'validatePassword'],

            [['device'], 'required', 'on' => 'api'],
            ['device', 'integer', 'on' => 'api'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return AuthToken|null
     * @throws Exception
     */
    public function login()
    {
        if ($this->validate()) {
            if (!AuthToken::isAccessTokenValid($this->_user->id)) {
                $auth = new AuthToken();
                $auth->user_id = $this->_user->id;
                $auth->access_token = Yii::$app->security->generateRandomString();
                $auth->expired_at = time() + Yii::$app->params['user.accessTokenExpire'];
                $auth->device_id = $this->device;
                $result = $auth->save();
                if (!$result) {
                    throw new Exception(current($auth->getFirstErrors()));
                }
            } else {
                $auth = AuthToken::findOne(['user_id' => $this->_user->id]);
            }
            if (Yii::$app->getUser()->login($this->_user)) {
                return $auth;
            }
        } else {
            return null;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
