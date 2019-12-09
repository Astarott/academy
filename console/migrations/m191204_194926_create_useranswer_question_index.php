<?php

use yii\db\Migration;

/**
 * Class m191204_194926_create_useranswer_question_index
 */
class m191204_194926_create_useranswer_question_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-user-answer-question_id',
            'user_answer',
            'question_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-answer-question_id',
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
        echo "m191204_194926_create_useranswer_question_index cannot be reverted.\n";

        return false;
    }
    */
}
