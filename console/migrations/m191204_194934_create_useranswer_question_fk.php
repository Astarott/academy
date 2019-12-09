<?php

use yii\db\Migration;

/**
 * Class m191204_194934_create_useranswer_question_fk
 */
class m191204_194934_create_useranswer_question_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-user-answer-question_id',
            'user_answer',
            'question_id',
            'question',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user-answer-question_id',
            'user_answer'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191204_194934_create_useranswer_question_fk cannot be reverted.\n";

        return false;
    }
    */
}
