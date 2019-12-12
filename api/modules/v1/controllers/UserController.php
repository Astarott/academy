<?php

namespace api\modules\v1\controllers;

use api\models\SendMailForm;
use api\models\SignupForm;
use api\models\SignupFullForm;
use common\models\User;
use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;
use function GuzzleHttp\Promise\all;

class UserController extends ActiveController
{
    public $modelClass = User::class;

    protected function verbs()
    {
        return [
            'signup' => ['get', 'post'],
            'mail' => ['post'],
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

        if ($model->signup())
            return ['message' => 'Пользователь успешно сохранен'];
//            $response = Yii::$app->getResponse();
//            $response->setStatusCode(201);
        else if (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Невозможно создать пользователя по неизвестным причинам.');
        }
        return ($model);
    }

    public function actionGetallstudents()
    {
        $query = new Query();
        $query->select('user.fio')->from('{{token}}')->join('JOIN', '{{public.user}}', 'public.user.id = public.token.user_id')->where(['public.user.status' => 11])->all();
        $command = $query->createCommand();
        $resp = $command->query();
        return $resp;
    }


    public function actionSendMails()
    {
        $query = new Query();
        $query->select('user.email')->from('{{user}}')->where('user.status' == 11)->all();
        $command = $query->createCommand()->query();
        foreach ($command as $item) {
            $mail = $item["email"];
            $user = User::findOne(["email" => $mail]);
            if (!$this->sendEmail($user)) {
                return ['message' => 'Сообщение пользователю с ' . $mail . ' почтой не отправилось'];
            }
        }
        return (['massage' => 'Сообщения были отправлены']);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['email'] => 'Ссылка на сайт'])
            ->setTo($user->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

    public function actionSignupSecond()
    {
        if (Yii::$app->request->isGet)
        {
            $token = Yii::$app->getRequest()->getQueryParam('token');

            return ($token);

            $user = User::findByVerificationToken($token);
            http://academy.local/v1/signup


            if ($user == null) {
                return (['message' => 'Вы ввели неверный токен']);
            }
            return ($user);
//        }
//        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
//        return ($model->email);
        }
    }
}