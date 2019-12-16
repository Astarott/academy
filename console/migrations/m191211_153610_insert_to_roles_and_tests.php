<?php

use yii\db\Migration;

/**
 * Class m191211_153610_insert_to_roles_and_tests
 */
class m191211_153610_insert_to_roles_and_tests extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%role}}',['name','id'], [['менеджер','1'],['аналитик','2'],['фронтэнд','3'],['бэкэнд','4'],['тестировщик','5'],['дизайнер','6']]);
        $this->batchInsert('{{%test}}',['role_id','id'], [['1','1'],['2','2'],['3','3'],['4','4'],['5','5'],['6','6']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%test}}', ['in', 'role_id', ['1','2','3','4','5','6']]);
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
