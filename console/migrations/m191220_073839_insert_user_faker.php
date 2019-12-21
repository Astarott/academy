<?php

use common\models\User;
use Faker\Factory;
use yii\db\Migration;

/**
 * Class m191220_073839_insert_user_faker
 */
class m191220_073839_insert_user_faker extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Factory::create();
        for($i = 0; $i < 11; $i++)
        {


            $posts = [];

            for ($j = 0; $j < 1; $j++)
            {
                $fake_pass = new User();
                $password =  $faker->text(10);
                $fake_pass->setPassword($password);
                $pass = $fake_pass->password_hash;

                $password =  $faker->text(10);

                $posts[] = [
                    $faker->unique()->numberBetween(80,90),
                    $faker->numberBetween(18, 100),
                    $faker->unixTime(),
                    $faker->text(10),
                    $faker->unique()->email,
                    $password,
                    $faker->text(10),
                    $faker->numberBetween(0,100),
                    $pass,
                    $faker->unixTime(),
                    $faker->numberBetween(1,4),
                    $faker->numberBetween(11,12),
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
        $this->delete('{{%user}}', ['in', 'id', [80,81,82,83,84,85,86,87,88,89,90]]);

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191220_073839_insert_user_faker cannot be reverted.\n";

        return false;
    }
    */
}
