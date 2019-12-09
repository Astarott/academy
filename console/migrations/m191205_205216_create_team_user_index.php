<?php

use yii\db\Migration;

/**
 * Class m191205_205216_create_team_user_index
 */
class m191205_205216_create_team_user_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-team-creator_id',
            'team',
            'creator_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-team-creator_id',
            'team'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_205216_create_team_user_index cannot be reverted.\n";

        return false;
    }
    */
}
