<?php

use yii\db\Migration;

/**
 * Class m191204_171450_create_testquestion_question_fk
 */
class m191204_171450_create_testquestion_question_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-test-question-question_id',
            'test_question',
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
            'fk-test-question-question_id',
            'test_question'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191204_170923_create_testquestion_question_fk cannot be reverted.\n";

        return false;
    }
    */
}
