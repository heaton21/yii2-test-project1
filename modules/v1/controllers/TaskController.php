<?php

namespace app\modules\v1\controllers;
use app\models\Task;
use app\models\Tag;

class TaskController extends JsonController
{
    public $modelClass = Task::class;  

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['update']);
        return $actions;
    }

    public function actionIndex()
    {
    	return $this->modelClass::find()->with('tags')->all();
    }

    public function actionCreate()
    {
        $model = new $this->modelClass();
        $request = \Yii::$app->request;
        $model->title = $request->post('title');

        if ($model->validate()) {
            $tag = $model->setTags(Tag::findAll($request->post('tags')));
            $model->save();

            foreach ($tag->tags as $value) {
                $model->link('tags', $value);
            }

            return ['status' => true, 'data'=> 'Task record is created successfully'];

        } else {

            return ['status' => false, 'errors'=> $model->errors];
        }

    }

    public function actionUpdate(Task $task, $id)
    {
        $task = $task->findOne($id);
        if (!$task) {
            throw new \yii\web\NotFoundHttpException();
        }

        $request = \Yii::$app->request->bodyParams;
        $task->load($request, '');
        $tag = $task->setTags(Tag::findAll($request['tags']));
        $task->save();
        if ($tag) {
            \Yii::$app->db->createCommand()
            ->delete('tag_tasks', 'task_id = :id')
            ->bindParam(':id', $task->id)
            ->execute();
        }
        foreach ($tag->tags as $value) {
            $task->link('tags', $value);
        }
        return $task;
    }

    public function actionStatus(Task $task, $id)
    {
        $task = $task->findOne($id);
        if (!$task) {
            throw new \yii\web\NotFoundHttpException();
        }

        if ($task->isOpen()) {
            $task->status = 1;
            $task->completed_at = new \yii\db\Expression('NOW()');
            $task->save();
            return ['status' => 'true', 'message' => 'task completed!'];
        }

        if ($task->isClosed()) {
            $task->status = 0;
            $task->completed_at = null;
            $task->save();
            return ['status' => 'true', 'message' => 'task opened!'];
        }
    }

}