<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_key}}`.
 */
class m191208_135959_create_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer() -> notNull(),
            'token' => $this->string()->notNull()->unique(),
            'expired_at' => $this-> integer()->notNull(),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%token}}');
    }
}
