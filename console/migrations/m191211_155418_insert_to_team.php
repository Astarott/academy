<?php

use yii\db\Migration;

/**
 * Class m191211_155418_insert_to_team
 */
class m191211_155418_insert_to_team extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%team}}',['name'], [['огурцы'],['картон'],['СВЧ'],['фест'],['джекдэниелс'],['анимешники'],['спортивный элемент'],['чокопайки'],['уточки'],['чайник'],['зубочистки'],['пряники'],['чайный пакетик'],['соевая лужа'],['тпликн'],['зуко'],['наушный разъем'],['джира из этого самого'],['каччан'],['цементос'],['отшельники']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%team}}', ['in', 'name', ['огурцы','картон','СВЧ','фест','джекдэниелс','анимешники','спортивный элемент','чокопайки','уточки','чайник','зубочистки','пряники','чайный пакетик','соевая лужа','тпликн','зуко','наушный разъем','джира из этого самого','каччан','цементос', 'отшельники']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191211_155418_insert_to_team cannot be reverted.\n";

        return false;
    }
    */
}
