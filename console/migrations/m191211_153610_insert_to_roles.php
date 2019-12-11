<?php

use yii\db\Migration;

/**
 * Class m191211_153610_insert_to_roles
 */
class m191211_153610_insert_to_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%role}}',['name'], [['менеджер'],['аналитик'],['фронтэнд'],['бэкэнд'],['тестировщик'],['дизайнер']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%role}}', ['in', 'name', ['менеджер','аналитик','фронтэнд','бэкэнд','тестировщик','дизайнер']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191211_153610_insert_to_roles cannot be reverted.\n";

        return false;
    }
    */
}
