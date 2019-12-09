<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test_question}}`.
 */
class m191204_165802_create_test_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test_question}}', [
            'test_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull(),
            'PRIMARY KEY(test_id, question_id)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%test_question}}');
    }
}
