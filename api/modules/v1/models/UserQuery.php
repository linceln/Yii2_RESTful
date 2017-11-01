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
        return self::alias('u')
            ->addSelect(['u.id', 'u.username', 'u.avatars', 'u.mobile', 'u.status']);
    }

    public function joinWithBmi()
    {
        return self::joinWith("bmi b")
            ->addSelect(['b.user_id', 'b.weight', 'b.height', 'b.bmi']);
    }
}