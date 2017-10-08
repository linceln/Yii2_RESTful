<?php

namespace common\models;

use yii\base\UserException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "bmi".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $weight
 * @property string $height
 * @property number $bmi
 */
class Bmi extends ActiveRecord
{

    public $average;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bmi}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'weight', 'height', 'bmi'], 'required'],
            [['user_id'], 'unique'],
            [['user_id'], 'integer'],
            [['weight', 'height', 'bmi'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'weight' => 'Weight',
            'height' => 'Height',
            'bmi' => 'Bmi',
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if ($this->height != 0) {
                $this->bmi = $this->weight / ($this->height / 100 * $this->height / 100);
            }
            return true;
        }
    }

    /**
     * @return BmiQuery
     */
    public static function find()
    {
        return new BmiQuery(get_called_class());
    }

    public function create($user_id)
    {
        $this->user_id = $user_id;
        return $this->save();
    }

    public static function averageBmi()
    {
        return self::find()
            ->addSelectAverageBmi()
            ->one();
    }

    public static function updateBmi($bmi_id, $data)
    {
        $bmi = self::find()
            ->andWhereIdentifiedUser()
            ->andWhereBmiId($bmi_id)
            ->one();

        if (!$bmi) {
            throw new NotFoundHttpException();
        }

        if ($bmi && $bmi->load($data, '')) {
            $bmi->save();
            return true;
        } else {
            throw new UserException(current($bmi->getFirstErrors()));
        }
    }

    public static function testUnion()
    {
        $_15 = self::find()
            ->select(['user_id', 'mobile', 'bmi'])
            ->where(['user_id' => 15])
            ->orderBy(['bmi' => SORT_ASC])// 部分数据排序
            ->limit(9999);// 必须加 limit() 才能在 union() 时排序

        $_14 = self::find()
            ->select(['user_id', 'mobile', 'bmi'])
            ->where(['user_id' => 14])
            ->orderBy(['bmi' => SORT_ASC])// 部分数据排序
            ->limit(9999);// 必须加 limit() 才能在 union() 时排序

        return self::find()
            ->from(['q' => $_14->union($_15)])// $_14->union($_15) 返回的数据可以当作一张表，'q' 是别名
//            ->orderBy(['bmi' => SORT_ASC]) // 全部数据排序
            ->asArray()
            ->all();
    }
}
