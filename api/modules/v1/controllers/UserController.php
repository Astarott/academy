<?php

namespace api\modules\v1\controllers;

use api\models\SignupForm;
use api\models\SignupFullForm;
use common\models\User;
use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

class UserController extends ActiveController
{
    public $modelClass = User::class;

    protected function verbs()
    {
        return [
            'signup' => ['get','post'],
            'mail' => ['post'],
        ];
    }

    public function actionSignup()
    {
//        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        $model = new SignupForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->phone = $requestParams['phone'];
        $model->email = $requestParams['email'];
        $model->fio = $requestParams['fio'];

        if ($model->signup())
            return ['message' => 'Пользователь успешно сохранен'];
//            $response = Yii::$app->getResponse();
//            $response->setStatusCode(201);
        else if (!$model->hasErrors()){
            throw new ServerErrorHttpException('Невозможно создать пользователя по неизвестным причинам.');}
        return ($model);
    }

    public function actionGetallstudents(){
        $query = new Query();
        $query->select('user.fio')->from('{{token}}')->join('JOIN','{{public.user}}','public.user.id = public.token.user_id')->where(['public.user.status' => 11])->all();
        $command = $query->createCommand();
        $resp = $command->query();
        return $resp;
    }

    public function actionSignupSecond()
    {
        $model = new User;
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        return ($model->email);

//        $model = new SignupFullForm();
//
//        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        return ($model);



        return $model;


//        $requestParams = Yii::$app->getRequest()->getQueryParams();
//
//        $model = new SignupFullForm();
//        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
//        return ($model->load(Yii::$app->getRequest()->getBodyParams(),''));
//        return ($model->attributes);
//        return ($model->signup());
//        $model->
//        $model->userRoles = $requestParams['role'];
//        $model->age = $requestParams['age'];
//        $model->password = $requestParams['password'];
//        $model->experience = $requestParams['experience'];
//        $model->period = $requestParams['period'];
//        $model->work_status = $requestParams['work_status'];
//        $model->comment = $requestParams['comment'];
//        $model->study_place = $requestParams['study_place'];

//        return ($model->signup());


//        $model->

//        return ("TEST");
    }
//        return ($model->save());
//        if ($model->signup())
//        {
//            $response = Yii::$app->getResponse();
//            $response->setStatusCode(201);
//            $id = implode(',', array_values($model->getPrimaryKey(true)));
//            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
//        } elseif (!$model->hasErrors())
//        {
//            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
//        }
//        return $model;
//    }
}
