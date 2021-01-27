<?php

namespace app\modules\v1\controllers;
use app\models\Task;
use app\models\Tag;

class TagController extends JsonController
{
    public $modelClass = Tag::class;  

    public function actions()
    {
        $actions = parent::actions();
        unset($actions);
        return $actions;
    }

    public function actionView($id)
    {
        return \Yii::$app->db
        ->createCommand('SELECT tasks.title, tasks.status, tags.name AS tag_name FROM `tag_tasks` 
            JOIN tasks ON tasks.id = tag_tasks.task_id
            JOIN tags ON tags.id = tag_tasks.tag_id
            WHERE tags.id = :id')
        ->bindValue(':id', $id)
        ->queryAll();
    }


}