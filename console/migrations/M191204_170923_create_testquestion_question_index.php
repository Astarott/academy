<?php

use yii\db\Migration;

/**
 * Class m191204_170923_create_testquestion_question_index
 */
class m191204_170923_create_testquestion_question_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-test-question-question_id',
            'test_question',
            'question_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-test-question-question_id',
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
        echo "m191204_170923_create_testquestion_question_index cannot be reverted.\n";

        return false;
    }
    */
}
