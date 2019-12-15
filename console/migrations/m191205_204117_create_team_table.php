<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%team}}`.
 */
class m191205_204117_create_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%team}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'project'=>$this->string(),

            'inSet'=>$this->boolean()->notNull()->defaultValue(false),
            //Руководитель или же наставник, который создал команду
            'creator_id'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%team}}');
    }
}
