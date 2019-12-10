<?php

namespace api\controllers\v1;

use api\models\SignupForm;
use api\models\User;
use Yii;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

class UserController extends ActiveController
{
    public $modelClass = User::class;

    protected function verbs()
    {
        return [
            'signup' => ['post'],
//            'mail' => ['post'],
        ];
    }

    public function actionSignup()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $model = new SignupForm();
        $model->phone = $requestParams['phone'];
        $model->email = $requestParams['email'];
        $model->fio = $requestParams['fio'];
        return ($model->signup());
//    }
//        return ($model->save());
        if ($model->signup())
        {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
//            return ("Success");
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$model->hasErrors())
        {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}