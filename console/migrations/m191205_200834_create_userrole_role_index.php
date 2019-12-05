<?php

use yii\db\Migration;

/**
 * Class m191205_200834_create_userrole_role_index
 */
class m191205_200834_create_userrole_role_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-user-role-role_id',
            'user_role',
            'role_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-role-role_id',
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
        echo "m191205_200834_create_userrole_role_index cannot be reverted.\n";

        return false;
    }
    */
}
