<?php

use Faker\Factory;
use yii\db\Migration;
/**
 * Class m191220_084340_insert_to_user_role_faker
 */
class m191220_084340_insert_to_user_role_faker extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Factory::create();
        for($i = 0; $i < 1; $i++)
        {
            $posts = [];

            for ($j = 0; $j < 11; $j++)
            {
                $posts[] = [
                    $j+80,
                    $j+80,
                    $faker->numberBetween(1, 6),
                    $faker->numberBetween(0,100),
                    $faker->date(),
                ];
            }

            $this->batchInsert('{{%user_role}}',['id','user_id','role_id','points','test_date'],$posts);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user_role}}', ['in', 'id', [80,81,82,83,84,85,86,87,88,89,90]]);

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191220_084340_insert_to_user_role_faker cannot be reverted.\n";

        return false;
    }
    */
}
