<?php

use yii\db\Migration;

/**
 * Class m191205_205240_create_user_team_user_index
 */
class m191205_205240_create_user_team_user_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-user-team-user_id',
            'user_team',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-team-user_id',
            'user_team'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_205240_create_user_team_user_index cannot be reverted.\n";

        return false;
    }
    */
}
