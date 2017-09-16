<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "bmi".
 *
 * @property integer $id
 * @property string $name
 * @property number $weight
 * @property number $height
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
            [['name', 'weight', 'height', 'mobile', 'bmi'], 'required'],
            [['weight', 'height', 'bmi'], 'number'],
            [['mobile'], 'unique'],
            [['name', 'mobile'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'weight' => 'Weight',
            'height' => 'Height',
            'mobile' => 'Mobile',
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
        } else {
            return false;
        }
    }
}
