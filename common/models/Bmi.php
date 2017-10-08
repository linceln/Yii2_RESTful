<?php

namespace common\models;

use api\modules\v1\models\AuthToken;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "bmi".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $weight
 * @property string $height
 * @property string $mobile
 * @property number $bmi
 */
class Bmi extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bmi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'weight', 'height', 'mobile', 'bmi'], 'required'],
            [['mobile'], 'unique'],
            [['user_id'], 'integer'],
            [['weight', 'height', 'bmi'], 'number'],
            [['mobile'], 'string', 'max' => 255],
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
            'mobile' => 'Mobile',
            'bmi' => 'Bmi',
        ];
    }

    public function create($user_id)
    {
        $this->user_id = $user_id;
        if ($this->height != 0) {
            $this->bmi = $this->weight / ($this->height / 100 * $this->height / 100);
        }
        return $this->save();
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
