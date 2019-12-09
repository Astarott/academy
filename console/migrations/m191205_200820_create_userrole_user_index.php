<?php

use yii\db\Migration;

/**
 * Class m191205_200820_create_userrole_user_index
 */
class m191205_200820_create_userrole_user_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-user-role-user_id',
            'user_role',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-role-user_id',
            'user_role'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_200820_create_userrole_user_index cannot be reverted.\n";

        return false;
    }
    */
}
