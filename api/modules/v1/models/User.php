<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 2017/10/24
 * Time: 01:56
 */

namespace api\modules\v1\models;

use yii\data\ActiveDataProvider;

class User extends \common\models\User
{
    /**
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public static function index($page)
    {
        $query = self::find()
            ->selectUser()
            ->with('bmi');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'page' => $page,
                'pageSize' => 10,
                'totalCount' => $query->count(),
            ],
            'sort' => [
                'defaultOrder' => [
                    'status' => SORT_DESC,
                    'updated_at' => SORT_DESC,
                    'created_at' => SORT_DESC,
                    'username' => SORT_ASC
                ]
            ]
        ]);

        return $dataProvider;
    }
}