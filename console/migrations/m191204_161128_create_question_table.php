<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question}}`.
 */
class m191204_161128_create_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string()->notNull(),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%question}}');
    }
}
