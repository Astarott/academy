<?php

use yii\db\Migration;

/**
 * Class m191213_094905_insert_to_user
 */
class m191213_095310_insert_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user}}',['id','age','created_at','comment','email','experience','fio','last_point','password_hash','period','phone','status','updated_at'],
            [[134345,19,1576226554,'test_com','mayemail@kek.ru','big exp','Purgen', 31,'$2y$13$ypMKWieUuG0Ie8Rktp361.LJgUjxuQUOUL654XKySWhIOtwvfl/Ly','asd','234',12,1576226554],
                [134346,19,1576226555,'test_com','test@test.ru','big exp','Kargen', 32,'$2y$13$ypMKWieUuG0Ie8Rktp361.LJgUjxuQUOUL654XKySWhIOtwvfl/Ly','asdd','234',12,1576226555],
                [134347,18,1576226556,'test_com','tested@test.ru','big exp','Morgen', 33,'$2y$13$ypMKWieUuG0Ie8Rktp361.LJgUjxuQUOUL654XKySWhIOtwvfl/Ly','asdd','234',12,1576226556]]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['in', 'id', ['134345','134346','134347']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191213_094905_insert_to_user cannot be reverted.\n";

        return false;
    }
    */
}
