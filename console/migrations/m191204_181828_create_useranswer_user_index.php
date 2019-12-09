<?php

use yii\db\Migration;

/**
 * Class m191204_181828_create_useranswer_user_index
 */
class m191204_181828_create_useranswer_user_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-user-answer-user_id',
            'user_answer',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-answer-user_id',
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
        echo "m191204_181828_create_useranswer_user_index cannot be reverted.\n";

        return false;
    }
    */
}
