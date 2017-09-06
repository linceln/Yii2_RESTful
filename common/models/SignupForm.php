<?php

namespace common\models;

use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $mobile;
    public $password;
    public $passwordRepeat;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['mobile', 'trim'],
            ['mobile', 'required'],
//            ['mobile', 'mobile'],
            ['mobile', 'string', 'max' => 11],
            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This mobile has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['passwordRepeat', 'required'],
            ['passwordRepeat', 'string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->mobile;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save(false) ? $user : null;
    }
}
