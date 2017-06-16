<?php

use yii\db\Migration;

/**
 * Handles the creation of table `guestbook`.
 */
class m170615_130038_create_guestbook_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('guestbook', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32)->notNull()->comment("Иям пользователя"),
            'email' => $this->string(48)->notNull()->comment("Электронный адрес"),
            'text' => $this->text()->notNull()->comment("Сообщение пользвателя"),
            'ip' => $this->string(15)->notNull()->comment("IP пользователя"),
            'userAgent' => $this->string(200)->notNull()->comment("Информация о браузере"),
            'date' => $this->timestamp()->notNull()->comment("Дата добавления"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('guestbook');
    }
}
