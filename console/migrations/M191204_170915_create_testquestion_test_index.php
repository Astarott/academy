<?php

use yii\db\Migration;

/**
 * Class m191204_170915_create_testquestion_test_index
 */
class m191204_170915_create_testquestion_test_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-test-question-test_id',
            'test_question',
            'test_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-test-question-test_id',
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
        echo "m191204_171458_create_testquestion_test_index cannot be reverted.\n";

        return false;
    }
    */
}
