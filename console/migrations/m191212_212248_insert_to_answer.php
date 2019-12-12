<?php

use yii\db\Migration;

/**
 * Class m191212_212248_insert_to_answer
 */
class m191212_212248_insert_to_answer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%answer}}',['text','is_right','question_id'],
                                                [['Почти',false,1],['Да',true,1],['Наверное',false,1],['Хотелось бы',false,1],
                                                 ['Да',false,2],['Очень',false,2],['Нет',false,2],['Крутая вещь, всем рекоммендую',true,2],
                                                 ['3',false,3],['4',true,3],['10.5',false,3],['5',false,3],
                                                 ['нажми',false,4],['сюды',false,4],['и будет',false,4],['круть',true,4],
                                                 ['Да',false,5],['Очень',true,5],['Нет',false,5],['Наверное',false,5],
                                                 ['не спать',false,6],['4',false,6],['8',true,6],['12',false,6]
                                                 ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%answer}}', ['in', 'question_id', ['1','2','3','4','5','6']]);

//        $this->delete('{{%answer}}', ['in', ['text','is_right','question_id'],
//            [['Почти','false','1'],['Да',true,1],['Наверное',false,1],['Хотелось бы',false,1],
////                ['Да',false,2],['Очень',false,2],['Нет',false,2],['Крутая вещь, всем рекоммендую',true,2],
////                ['3',false,3],['4',true,3],['10.5',false,3],['5',false,3],
////                ['нажми',false,4],['сюды',false,4],['и будет',false,4],['круть',true,4],
////                ['Да',false,5],['Очень',true,5],['Нет',false,5],['Наверное',false,5],
////                ['не спать',false,6],['4',false,6],['8',true,6],['12',false,6]
//            ]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191212_212248_insert_to_answer cannot be reverted.\n";

        return false;
    }
    */
}
