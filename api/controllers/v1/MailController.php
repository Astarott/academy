<?php

namespace api\controllers\v1;
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