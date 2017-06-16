<?php
/**
 * Created by PhpStorm.
 * User: redminote
 * Date: 15.06.17
 * Time: 18:35
 */

namespace app\models;


use Yii;
use yii\base\Model;

class GuestbookForm extends Model
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $text;
    /**
     * @var string
     */
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // обязательны к заполнению
            [['username', 'email', 'text'], 'required'],

            // обрезать пробелы
            [['username', 'email'], 'trim'],

            // проверка на допустимость символов, разрешены только цифры и буквы латинского алфавита
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i'],

            [['text'], 'string'],
            [['username'], 'string', 'max' => 32, 'min' => 4],
            [['email'], 'string', 'max' => 48],
            [['email'], 'email'],

            // проверка капчи
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Эл. почта',
            'text' => 'Сообщение',
            'verifyCode' => 'Проверочный код',
        ];
    }

    /**
     * Сохранить запись в гостевую книгу
     *
     * @return Guestbook|null
     */
    public function save()
    {
        $guestBook = new Guestbook();

        $guestBook->username = $this->username;
        $guestBook->email = $this->email;
        $guestBook->text = strip_tags($this->text);

        $guestBook->ip = Yii::$app->request->userIP;
        $guestBook->userAgent = Yii::$app->request->userAgent;
        $guestBook->date = date("c");

        return $guestBook->save(false) ? $guestBook : null;
    }
}