<?php

use yii\db\Migration;

/**
 * Class m191213_111755_insert_to_user_team
 */
class m191213_111755_insert_to_user_team extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user_team}}',['id','user_id','team_id','created_at','updated_at'],
            [[134345 , 134345 , 1 ,'10-10-2010' , '10-10-2010'],
                [134346 , 134346 , 2 , '10-10-2012' , '10-10-2012'],
                [134347 , 134347 , 1 , '10-10-2013' , '10-10-2013']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user_team}}', ['in', 'id', [134345,134346,134347]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191213_111755_insert_to_user_team cannot be reverted.\n";

        return false;
    }
    */
}
