<?php

use yii\db\Migration;
use Faker\Factory;
use common\models\User;
/**
 * Class m191219_043312_factory_user
 */
class m191219_043312_factory_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Factory::create();
        for($i = 0; $i < 10; $i++)
        {


            $posts = [];

            for ($j = 0; $j < 10; $j++)
            {
                $fake_pass = new User();
                $password =  $faker->text(10);
                $fake_pass->setPassword($password);
                $pass = $fake_pass->password_hash;

                $password =  $faker->text(10);

                $posts[] = [
                    $faker->unique()->numberBetween(6,1000),
                    $faker->numberBetween(18, 100),
                    $faker->unixTime(),
                    11,
                    $password,
                    $faker->unique()->email,
                    $faker->text(10),
                    $faker->text(10),
                    $faker->numberBetween(0,100),
                    $pass,
                    $faker->numberBetween(1,4),
                    rand(0, 1),
                    $faker->unixTime()
                ];
            }

        $this->batchInsert('{{%user}}',['id','age','created_at','comment','email','experience','fio','last_point','password_hash','period','phone','status','updated_at'],$posts);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191219_043312_factory_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191219_043312_factory_user cannot be reverted.\n";

        return false;
    }
    */
}
