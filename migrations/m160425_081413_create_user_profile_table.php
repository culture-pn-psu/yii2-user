<?php

use yii\db\Migration;
use yii\db\Schema;

class m160425_081413_create_user_profile_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            //$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->primaryKey(),
            'firstname' => $this->string(),
            'lastname' => $this->string(),
            'avatar' => $this->string(),
            'cover' => $this->string(),
            'bio' => $this->string(),
            'data' => $this->text(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user_profile}}');
    }
}
