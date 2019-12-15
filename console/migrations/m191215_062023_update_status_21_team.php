<?php

use yii\db\Migration;

/**
 * Class m191215_062023_update_status_21_team
 */
class m191215_062023_update_status_21_team extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update( '{{%team}}', ['inSet' => true],['id' => 21] );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191215_062023_update_status_21_team cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191215_062023_update_status_21_team cannot be reverted.\n";

        return false;
    }
    */
}
