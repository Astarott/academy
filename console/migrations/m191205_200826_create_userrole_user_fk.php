<?php

use yii\db\Migration;

/**
 * Class m191205_200826_create_userrole_user_fk
 */
class m191205_200826_create_userrole_user_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-user-role-user_id',
            'user_role',
            'user_id',
            'user',
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
            'fk-user-role-user_id',
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
        echo "m191205_200826_create_userrole_user_fk cannot be reverted.\n";

        return false;
    }
    */
}
