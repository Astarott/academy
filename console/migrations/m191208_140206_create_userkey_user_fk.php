<?php

use yii\db\Migration;

/**
 * Class m191208_140206_create_userkey_user_fk
 */
class m191208_140206_create_userkey_user_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-token-user_id',
            'token',
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
            'fk-token-user_id',
            'token'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191208_140206_create_userkey_user_fk cannot be reverted.\n";

        return false;
    }
    */
}
