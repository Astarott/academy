<?php

use yii\db\Migration;

/**
 * Class m191208_140200_create_userkey_user_index
 */
class m191208_140200_create_userkey_user_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-token-user_id',
            'token',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-token-user_id',
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
        echo "m191208_140200_create_userkey_user_index cannot be reverted.\n";

        return false;
    }
    */
}
