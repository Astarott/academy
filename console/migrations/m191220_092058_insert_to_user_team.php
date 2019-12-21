<?php

use yii\db\Migration;
use Faker\Factory;
/**
 * Class m191220_092058_insert_to_user_team
 */
class m191220_092058_insert_to_user_team extends Migration
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
                    $faker->numberBetween(1, 21),
                    $faker->date(),
                    $faker->date(),
                ];
            }

            $this->batchInsert('{{%user_team}}',['id','user_id','team_id','created_at','updated_at'],$posts);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user_team}}', ['in', 'id', [80,81,82,83,84,85,86,87,88,89,90]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191220_092058_insert_to_user_team cannot be reverted.\n";

        return false;
    }
    */
}
