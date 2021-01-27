<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $title
 * @property int|null $status
 * @property string $created_at
 * @property string|null $completed_at
 */
class Task extends \yii\db\ActiveRecord
{

    const TASK_OPENED = 'Задача открыта';
    const TASK_CLOSED = 'Задача закрыта';

    const TASK_STATUS = [
        0 => self::TASK_OPENED,
        1 => self::TASK_CLOSED,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'completed_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'created_at' => 'Created At',
            'completed_at' => 'Completed At',
        ];
    }

    public function isOpen()
    {
        return $this->status == 0;
    }

    public function isClosed()
    {
        return $this->status == 1;
    }

    public function getStatus() :string
    {
        return self::TASK_STATUS[$this->status];
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('tag_tasks', ['task_id' => 'id']);
    }

    public function fields() :array
    {
        // $fields = parent::fields();
        // $fields[]='tags';
        // return $fields;
        return [
            'id',
            'title',
            'task_status'=> function ($model) {
                return $model->getStatus(); 
            },
            'status',
            'created_at',
            'completed_at',
            'tags'
        ];
    }

    public function setTags($value)
    {
        $this->tags = $value;
        return $this;
    }

}
