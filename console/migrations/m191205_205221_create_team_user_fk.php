<?php

use yii\db\Migration;

/**
 * Class m191205_205221_create_team_user_fk
 */
class m191205_205221_create_team_user_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-team-creator_id',
            'team',
            'creator_id',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-team-creator_id',
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
        echo "m191205_205221_create_team_user_fk cannot be reverted.\n";

        return false;
    }
    */
}
