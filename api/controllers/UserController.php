<?php

namespace api\controllers;

use api\models\SignupForm;
use api\models\User;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

class UserController extends ActiveController
{
    public  $modelClass = User::class;

    protected  function  verbs()
    {
        return [
            'signup' => ['post'],
//            'mail' => ['post'],
        ];
    }


//    public function  actionSignup()
//    {
//        $model = new SignupForm();
//        \
//        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
//
//        if ($model->save())
//        {
//            $response = Yii::$app->getResponse();
//            $response->setStatusCode(201);
//            $id = implode(',', array_values($model->getPrimaryKey(true)));
//            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
//        } elseif (!$model->hasErrors()) {
//            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
//        }
//
//        return $model;
//        {
//            if ($user = $model->signup()) {
//                if (Yii::$app->getUser()->login($user)) {
//                    return $this->goHome();
//                }
//            }
//        }

//    }
}