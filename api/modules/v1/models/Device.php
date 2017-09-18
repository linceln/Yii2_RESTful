<?php

namespace api\modules\v1\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "device".
 *
 * @property integer $id
 * @property string $name
 * @property string $salt
 */
class Device extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'salt'], 'required'],
            [['id'], 'integer'],
            [['name', 'salt'], 'string', 'max' => 255],
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
            'salt' => 'Salt',
        ];
    }
}
