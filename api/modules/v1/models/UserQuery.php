<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 2017/10/24
 * Time: 01:58
 */

namespace api\modules\v1\models;

use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{

    public function selectUser()
    {
        return self::addSelect(['id', 'username', 'avatars', 'mobile', 'status']);
    }
}