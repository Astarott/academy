<?php

use yii\db\Migration;

/**
 * Class m191205_202824_create_test_role_index
 */
class m191205_202824_create_test_role_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-test-role_id',
            'test',
            'role_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-test-role_id',
            'test'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_202824_create_test_role_index cannot be reverted.\n";

        return false;
    }
    */
}
