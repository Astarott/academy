<?php

use yii\db\Migration;

/**
 * Class m191204_181409_create_answer_question_index
 */
class m191204_181409_create_answer_question_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-answer-question_id',
            'answer',
            'question_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-answer-question_id',
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
        echo "m191204_181409_create_answer_question_index cannot be reverted.\n";

        return false;
    }
    */
}
