<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_answer}}`.
 */
class m191204_181741_create_user_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_answer}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'answer_id'=> $this->integer()->notNull(),
            'question_id'=> $this->integer()->notNull(),
            'created_at'=> $this->dateTime(),
            'updated_at'=> $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_answer}}');
    }
}
