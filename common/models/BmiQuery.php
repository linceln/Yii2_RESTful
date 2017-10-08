<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 08/10/2017
 * Time: 21:45
 */

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

class BmiQuery extends ActiveQuery
{
    public function andWhereIdentifiedUser()
    {
        return $this->andWhere(['user_id' => Yii::$app->user->identity->getId()]);
    }

    public function andWhereBmiId($id)
    {
        return $this->andWhere(['id' => $id]);
    }

    public function addSelectAverageBmi()
    {
        return $this->addSelect('AVG(bmi) AS average');
    }
}