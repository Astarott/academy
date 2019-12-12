<?php

use yii\db\Migration;

/**
 * Class m191212_210701_insert_to_test_question
 */
class m191212_210701_insert_to_test_question extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%test_question}}',['test_id','question_id'], [['1','1'],['1','2'],['1','3'],['1','4'],['1','5'],['1','6']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%test_question}}', ['in', ['test_id','question_id'] , [['1','1'],['1','2'],['1','3'], ['1','4'],['1','5'],['1','6']]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191212_210701_insert_to_test_question cannot be reverted.\n";

        return false;
    }
    */
}
