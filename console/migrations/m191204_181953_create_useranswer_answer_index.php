<?php

use yii\db\Migration;

/**
 * Class m191204_181953_create_useranswer_answer_index
 */
class m191204_181953_create_useranswer_answer_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-user-answer-answer_id',
            'user_answer',
            'answer_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-answer-answer_id',
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
        echo "m191204_181953_create_useranswer_answer_index cannot be reverted.\n";

        return false;
    }
    */
}
