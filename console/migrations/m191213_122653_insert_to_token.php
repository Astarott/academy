<?php

use yii\db\Migration;

/**
 * Class m191213_122653_insert_to_token
 */
class m191213_122653_insert_to_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%token}}',['expired_at','id','token','user_id'],
            [[123134441 , 134345 ,'dfgdsdfssfs',134345],[123134442 , 134346 ,'vregergerg',134346],
                [123134443 ,  134347 ,'dfgdgdrgdfg',134347]]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%answer}}', ['in', 'id', [134345,134346,134347]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191213_122653_insert_to_token cannot be reverted.\n";

        return false;
    }
    */
}
