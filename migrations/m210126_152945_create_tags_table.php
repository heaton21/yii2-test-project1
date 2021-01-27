<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tags}}`.
 */
class m210126_152945_create_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->unique(),
        ]);

        $this->createTable('{{%tag_tasks}}', [
            'tag_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
        ]);

        $this->batchInsert('tags', ['name'], [
            ['DataBase'],
            ['MySQL'],
            ['PHP7'],
            ['Framework'],
            ['Yii'],
            ['Job'],
            ['Api'],
            ['CRUD'],
            ['SQL'],
            ['Backend'],
            ['Json'],
            ['MVC'],
            ['PHP'],
            ['Web'],
            ['OOP'],
        ]);

        $this->batchInsert('tag_tasks', ['tag_id', 'task_id'], [
            [1, 1],
            [1, 2],
            [1, 7],
            [6, 7],
            [2, 2],
            [3, 3],
            [3, 1],
            [2, 7],
            [3, 7],
            [4, 7],
            [5, 7]
        ]);

        $this->createIndex(
            '{{%idx-tag_tasks-tag_id}}',
            '{{%tag_tasks}}',
            'tag_id'
        );

        $this->addForeignKey(
            '{{%fk-tag_tasks-tag_id}}',
            '{{%tag_tasks}}',
            'tag_id',
            '{{%tags}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-tag_tasks-task_id}}',
            '{{%tag_tasks}}',
            'task_id'
        );

        $this->addForeignKey(
            '{{%fk-tag_tasks-task_id}}',
            '{{%tag_tasks}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-tag_tasks-tag_id}}',
            '{{%tag_tasks}}'
        );

        $this->dropIndex(
            '{{%idx-tag_tasks-tag_id}}',
            '{{%tag_tasks}}'
        );

        $this->dropForeignKey(
            '{{%fk-tag_tasks-task_id}}',
            '{{%tag_tasks}}'
        );

        $this->dropIndex(
            '{{%idx-tag_tasks-task_id}}',
            '{{%tag_tasks}}'
        );
        $this->delete('tag_tasks');
        $this->delete('tags');
        $this->dropTable('{{%tags}}');
        $this->dropTable('{{%tag_tasks}}');
    }
}
