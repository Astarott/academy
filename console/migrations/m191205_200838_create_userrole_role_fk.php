<?php

use yii\db\Migration;

/**
 * Class m191205_200838_create_userrole_role_fk
 */
class m191205_200838_create_userrole_role_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-user-role-role_id',
            'user_role',
            'role_id',
            'role',
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
            'fk-user-role-role_id',
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
        echo "m191205_200838_create_userrole_role_fk cannot be reverted.\n";

        return false;
    }
    */
}
