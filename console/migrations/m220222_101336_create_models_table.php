<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%models}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%makes}}`
 */
class m220222_101336_create_models_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%models}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'make_id' => $this->integer(),
            'status' => $this->integer(),

        ]);

        // creates index for column `make_id`
        $this->createIndex(
            '{{%idx-models-make_id}}',
            '{{%models}}',
            'make_id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%makes}}`
        $this->dropForeignKey(
            '{{%fk-models-make_id}}',
            '{{%models}}'
        );

        // drops index for column `make_id`
        $this->dropIndex(
            '{{%idx-models-make_id}}',
            '{{%models}}'
        );

        $this->dropTable('{{%models}}');
    }
}
