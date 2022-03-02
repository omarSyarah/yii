<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%makes}}`.
 */
class m220222_101527_create_makes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%makes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'status' => $this->integer(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%makes}}');
    }
}
