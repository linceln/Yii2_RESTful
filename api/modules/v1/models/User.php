<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 2017/10/24
 * Time: 01:56
 */

namespace api\modules\v1\models;

class User extends \common\models\User
{
    /**
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public static function index()
    {
        return self::find()
            ->selectUser()
            ->asArray()
            ->all();
    }
}