<?php

use yii\db\Migration;

/**
 * Class m191213_110942_insert_to_user_role
 */
class m191213_110942_insert_to_user_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user_role}}',['id','user_id','role_id','points','test_date'],
            [[134345,134345,1,86,'10-10-2010'],
                [134346,134346,2,85,'10-10-2012'],
                [134347,134347,1,67,'10-10-2011']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%answer}}', ['in', 'id', [134345,134346,134347]]);
    }

}
