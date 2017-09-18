<?php

namespace api\modules\v1\models;

use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "auth_token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $access_token
 * @property integer $expired_at
 * @property integer $device_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property User user
 * @property Device device
 */
class AuthToken extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_token}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'access_token', 'expired_at', 'device_id'], 'required'],
            [['user_id', 'expired_at', 'device_id'], 'integer'],
            [['access_token'], 'string', 'max' => 255],
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
            'access_token' => 'Access Token',
            'expired_at' => 'Expired At',
            'device_id' => 'Device ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 判断 access_token 是否过期
     * @param $user_id
     * @return bool
     */
    public static function isAccessTokenValid($user_id)
    {
        $auth = self::find()
            ->select(['access_token', 'expired_at'])
            ->where(['user_id' => $user_id])
            ->one();

        if (!$auth || empty($auth->access_token)) {
            return false;
        }

        return $auth->expired_at > time();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDevice()
    {
        return $this->hasOne(Device::className(), ['id' => 'device_id']);
    }
}
