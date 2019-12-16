<?php

use yii\db\Migration;

/**
 * Class m191215_143654_insert_to_user_admin
 */
class m191215_143654_insert_to_user_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user}}',['id','age','created_at','comment','email','experience','fio','last_point','password_hash','period','phone','status','updated_at'],
            [[5,200,1576226554,'admin','academyadmin@rg.ru','admin_exp','Admin', 31,'$2y$13$c7zGpu1prEBjpe2iBRkoQeKD78FC57GmsQjTxQlCx7ayRNWoypzQ6','asd','234',15,1576226554]]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->delete('{{%user}}', ['in', 'id', [5]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191215_143654_insert_to_user_admin cannot be reverted.\n";

        return false;
    }
    */
}
