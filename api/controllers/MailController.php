<?php

namespace api\controllers;
use yii\rest\Controller;

class MailController extends Controller
{
    public function actionIndex()
    {
        return 'api';
    }
    protected  function  verbs()
    {
        return [
            'login' => ['post'],
        ];
    }
}