<?php

use yii\db\Migration;

/**
 * Class m191205_205253_create_user_team_team_index
 */
class m191205_205253_create_user_team_team_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-user-team-team_id',
            'user_team',
            'team_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-team-team_id',
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
        echo "m191205_205253_create_user_team_team_index cannot be reverted.\n";

        return false;
    }
    */
}
