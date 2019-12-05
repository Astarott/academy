<?php

use yii\db\Migration;

/**
 * Class m191205_205245_create_user_team_user_fk
 */
class m191205_205245_create_user_team_user_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-user-team-user_id',
            'user_team',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user-team-user_id',
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
        echo "m191205_205245_create_user_team_user_fk cannot be reverted.\n";

        return false;
    }
    */
}
