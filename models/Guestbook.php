<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "guestbook".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $text
 * @property string $ip
 * @property string $userAgent
 * @property string $date
 */
class Guestbook extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guestbook';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'text', 'ip', 'userAgent', 'date'], 'required'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['username'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 48],
            [['ip'], 'string', 'max' => 15],
            [['userAgent'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'email' => 'Эл. почта',
            'text' => 'Сообщение',
            'ip' => 'Ip',
            'userAgent' => 'User Agent',
            'date' => 'Дата',
        ];
    }
}
