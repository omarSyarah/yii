<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%makes}}`
 * - `{{%models}}`
 * - `{{%cities}}`
 */
class m220222_101500_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'price' => $this->integer()->notNUll(),
            'make_id' => $this->integer()->notNUll(),
            'model_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger(),
            'is_new' => $this->smallInteger(),

            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->dateTime(),
        ]);

        // creates index for column `make_id`
        $this->createIndex(
            '{{%idx-posts-make_id}}',
            '{{%posts}}',
            'make_id'
        );


        // creates index for column `model_id`
        $this->createIndex(
            '{{%idx-posts-model_id}}',
            '{{%posts}}',
            'model_id'
        );



        // creates index for column `city_id`
        $this->createIndex(
            '{{%idx-posts-city_id}}',
            '{{%posts}}',
            'city_id'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%makes}}`
        $this->dropForeignKey(
            '{{%fk-posts-make_id}}',
            '{{%posts}}'
        );

        // drops index for column `make_id`
        $this->dropIndex(
            '{{%idx-posts-make_id}}',
            '{{%posts}}'
        );

        // drops foreign key for table `{{%models}}`
        $this->dropForeignKey(
            '{{%fk-posts-model_id}}',
            '{{%posts}}'
        );

        // drops index for column `model_id`
        $this->dropIndex(
            '{{%idx-posts-model_id}}',
            '{{%posts}}'
        );

        // drops foreign key for table `{{%cities}}`
        $this->dropForeignKey(
            '{{%fk-posts-city_id}}',
            '{{%posts}}'
        );

        // drops index for column `city_id`
        $this->dropIndex(
            '{{%idx-posts-city_id}}',
            '{{%posts}}'
        );

        $this->dropTable('{{%posts}}');
    }
}
