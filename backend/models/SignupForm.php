<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 19/08/2017
 * Time: 20:58
 */

namespace backend\models;

use yii\base\Model;
use backend\models\UserBackend as User;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $passwordRepeat;
    public $email;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'backend\models\UserBackend', 'message' => 'This username has been taken'],
            ['username', 'string', 'min' => 6, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'backend\models\UserBackend', 'message' => 'This email has been taken'],
            ['email', 'string', 'min' => 6, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 255],
            ['passwordRepeat', 'required'],
            ['passwordRepeat', 'string', 'min' => 6, 'max' => 255],

            ['passwordRepeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $user->save(false);

        return $user;
    }
}