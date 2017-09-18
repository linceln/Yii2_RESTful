<?php

namespace common\models;

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
        return $this->save();
    }
}
