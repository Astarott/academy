<?php

use yii\db\Migration;

/**
 * Class m191204_181832_create_useranswer_user_fk
 */
class m191204_181832_create_useranswer_user_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-user-answer-user_id',
            'user_answer',
            'user_id',
            'user',
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
            'fk-user-answer-user_id',
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
        echo "m191204_181832_create_useranswer_user_fk cannot be reverted.\n";

        return false;
    }
    */
}
