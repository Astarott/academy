<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer}}`.
 */
class m191204_181034_create_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string()-> notNull(),
            'is_right' => $this->boolean()->notNull()->defaultValue(false),
            'question_id' => $this ->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%answer}}');
    }
}
