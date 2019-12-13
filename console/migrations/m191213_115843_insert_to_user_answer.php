<?php

use yii\db\Migration;

/**
 * Class m191213_115843_insert_to_user_answer
 */
class m191213_115843_insert_to_user_answer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user_answer}}',['id','user_id','answer_id','question_id','created_at','updated_at'],
            [[134345 , 134345 , 1 , 1 , '10-10-2010','10-10-2010'],
                [134346 , 134346 , 2 , 2 , '10-10-2012','10-10-2012'],
                [134347 , 134347 , 3 , 3 , '10-10-2013','10-10-2013']]);
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
        echo "m191213_115843_insert_to_user_answer cannot be reverted.\n";

        return false;
    }
    */
}
