<?php

use yii\db\Migration;

/**
 * Class m191205_202829_create_test_role_fk
 */
class m191205_202829_create_test_role_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-test-role_id',
            'test',
            'role_id',
            'role',
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
            'fk-test-role_id',
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
        echo "m191205_202829_create_test_role_fk cannot be reverted.\n";

        return false;
    }
    */
}
