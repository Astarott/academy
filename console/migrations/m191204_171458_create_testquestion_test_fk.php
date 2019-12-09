<?php

use yii\db\Migration;

/**
 * Class m191204_171458_create_testquestion_test_fk
 */
class m191204_171458_create_testquestion_test_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-test-question-test_id',
            'test_question',
            'test_id',
            'test',
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
            'fk-test-question-test_id',
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
        echo "m191204_170915_create_testquestion_test_fk cannot be reverted.\n";

        return false;
    }
    */
}
