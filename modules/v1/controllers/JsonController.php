<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

class JsonController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] =  \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }
}