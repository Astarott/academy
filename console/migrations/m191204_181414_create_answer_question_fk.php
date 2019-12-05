<?php

use yii\db\Migration;

/**
 * Class m191204_181414_create_answer_question_fk
 */
class m191204_181414_create_answer_question_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-answer-question_id',
            'answer',
            'question_id',
            'question',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-answer-question_id',
            'answer'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191204_181414_create_answer_question_fk cannot be reverted.\n";

        return false;
    }
    */
}
