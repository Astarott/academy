<?php

use yii\db\Migration;

/**
 * Class m191215_154603_insert_to_token_admin
 */
class m191215_154603_insert_to_token_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%token}}',['expired_at','id','token','user_id'],
            [[123134441 , 5 ,'er',5]]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%token}}', ['in', 'id', [5]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191215_154603_insert_to_token_admin cannot be reverted.\n";

        return false;
    }
    */
}
