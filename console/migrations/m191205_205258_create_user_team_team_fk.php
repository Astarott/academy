<?php

use yii\db\Migration;

/**
 * Class m191205_205258_create_user_team_team_fk
 */
class m191205_205258_create_user_team_team_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-user-team-team_id',
            'user_team',
            'team_id',
            'team',
            'id',
            'NO ACTION',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user-team-team_id',
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
        echo "m191205_205258_create_user_team_team_fk cannot be reverted.\n";

        return false;
    }
    */
}
