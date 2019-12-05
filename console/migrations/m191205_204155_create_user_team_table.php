<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_team}}`.
 */
class m191205_204155_create_user_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_team}}', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'team_id'=>$this->integer()->notNull(),

            //Для сохранения данных
            'created_at'=>$this->dateTime(),
            'updated_at'=>$this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_team}}');
    }
}
