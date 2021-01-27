<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m210126_123633_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'status' => $this->boolean()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new \yii\db\Expression('NOW()')),
            'completed_at' => $this->dateTime(),
        ]);

        $this->insert('tasks', [
            'title' => 'Создать бд для проекта',
            'created_at' => new \yii\db\Expression('NOW()'),
        ]);

        $this->insert('tasks', [
            'title' => 'Создать миграцию задач (тасков)',
            'created_at' => new \yii\db\Expression('NOW()'),
        ]);

        $this->insert('tasks', [
            'title' => 'Create Rest Controller',
            'created_at' => new \yii\db\Expression('NOW()'),
        ]);

        $this->insert('tasks', [
            'title' => 'Hello World',
            'created_at' => new \yii\db\Expression('NOW()'),
            'status' => 1,
        ]);

        $this->insert('tasks', [
            'title' => 'Начать изучать Yii2 framework',
            'created_at' => new \yii\db\Expression('NOW()'),
        ]);

        $this->insert('tasks', [
            'title' => 'Разобраться с роутером',
            'created_at' => new \yii\db\Expression('NOW()'),
        ]);

        $this->insert('tasks', [
            'title' => 'Подготовка к собеседованию',
            'created_at' => new \yii\db\Expression('NOW()'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('tasks', ['id' => [1,2,3,4,5,6,7]]);
        $this->dropTable('{{%tasks}}');
    }
}
