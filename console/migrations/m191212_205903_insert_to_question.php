<?php

use yii\db\Migration;

/**
 * Class m191212_205903_insert_to_question
 */
class m191212_205903_insert_to_question extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%question}}',['text','id'], [['Любите ли вы жизнь','1'],['Нравится ли вам академия','2'],['Сколько будет 2+2','3'],['Выберите один из 4-ех пунктов','4'],['Любители ли вы покушать','5'],['Сколько часов в день стоит спать разработчику','6']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%question}}', ['in', 'text', ['Любите ли вы жизнь','Нравится ли вам академия','Сколько будет 2+2','Выберите один из 4-ех пунктов','Любители ли вы покушать','Сколько часов в день стоит спать разработчику']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191212_205903_insert_to_question cannot be reverted.\n";

        return false;
    }
    */
}
