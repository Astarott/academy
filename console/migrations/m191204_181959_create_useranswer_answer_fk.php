<?php

use yii\db\Migration;

/**
 * Class m191204_181959_create_useranswer_answer_fk
 */
class m191204_181959_create_useranswer_answer_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-user-answer-answer_id',
            'user_answer',
            'answer_id',
            'answer',
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
            'fk-user-answer-answer_id',
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
        echo "m191204_181959_create_useranswer_answer_fk cannot be reverted.\n";

        return false;
    }
    */
}
