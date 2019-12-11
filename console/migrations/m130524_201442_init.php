<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            //Идентификаторы
            'id' => $this->primaryKey(),
//            'username' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
//            'password_hash' => $this->string()->notNull(),

            //Стандарт
//            'auth_key' => $this->string(32)->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

            //Новое
            'password_hash' => $this->string(),
//            'auth_key' => $this->string(32),

            //Студент
            'phone' => $this-> string(),
            'fio'=>$this->string(),
            'age'=>$this->integer(),
            'study_place'=>$this->string(),
            'experience'=>$this->string(255),
            'period' => $this->integer(),
            'work_status'=>$this->boolean()->defaultValue(false),
            'comment'=>$this->string(),

            'last_point'=> $this->integer(),


            //Внешние ключики
//            'role_id'=>$this->integer(),
//            'team_id'=>$this->integer(),

            //Руководитель
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
