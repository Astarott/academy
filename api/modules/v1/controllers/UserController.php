<?php

namespace api\modules\v1\controllers;

use api\models\SignupForm;
use app\models\UserTeam;
use common\models\User;
use Yii;
use yii\db\Query;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

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
        else if (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Невозможно создать пользователя по неизвестным причинам.');
        }
        return ($model);
    }

    public function actionGetallstudents()
    {
        $query = new Query();
        $query->select(['user.id','user.fio', 'role.name AS role', 'team.name AS team_name', 'last_point'])->from('{{user}}')
            ->join('JOIN', '{{public.token}}', 'public.user.id = public.token.user_id')
            ->join('JOIN', '{{public.user_role}}', 'public.user.id = public.user_role.user_id')
            ->join('JOIN', '{{public.role}}', 'public.user_role.role_id = public.role.id')
            ->join('JOIN', '{{public.user_team}}', 'public.user.id = public.user_team.user_id')
            ->join('JOIN', '{{public.team}}', 'public.user_team.team_id = public.team.id')
            ->where(['public.user.status' => 12])->andWhere(['public.team.inSet' => 'true'])->orderBy('role')->all();
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
        $token = Yii::$app->getRequest()->getBodyParam('token');
        if (empty($token)) {
            $token = Yii::$app->getRequest()->getQueryParam('token');
        }
        $user_id = User::findByVerificationToken($token);
        if ($user_id == null) {
            return (['message' => 'Вы ввели неверный токен']);
        }
        if (Yii::$app->getRequest()->isPost) {
            $user = User::findOne(['id' => $user_id]);
            $user->load(Yii::$app->getRequest()->getBodyParams(), '');
            if ($user->SignupSecond()) {
                return (['message'=>'Регистрация прошла успешно']);
            }
            return ($user->SignupSecond());
        } elseif (Yii::$app->getRequest()->isGet) {
            $query = new Query();
            $query->select(['fio', 'email', 'phone'])->from('{{user}}')->where(['id' => $user_id])->one();
            $command = $query->createCommand();
            $resp = $command->query();
            return $resp;
        } else {
            return ['message' => 'Разрешены только GET и POST запросы'];
        }
    }

    public function actionGetuser()
    {
        $id = Yii::$app->getRequest()->getQueryParam('id');
        $query = new Query();
        $query->select(['user.id','user.fio', 'role.name AS role', 'team.name AS team_name', 'last_point','email'])->from('{{user}}')
            ->join('JOIN', '{{public.token}}', 'public.user.id = public.token.user_id')
            ->join('JOIN', '{{public.user_role}}', 'public.user.id = public.user_role.user_id')
            ->join('JOIN', '{{public.role}}', 'public.user_role.role_id = public.role.id')
            ->join('JOIN', '{{public.user_team}}', 'public.user.id = public.user_team.user_id')
            ->join('JOIN', '{{public.team}}', 'public.user_team.team_id = public.team.id')
            ->where(['public.user.id' => $id])->orderBy('role')->one();
        $command = $query->createCommand();
        $resp = $command->query();
        return $resp;
    }
    public function actionChangeTeam()
    {
        $user = new UserTeam();
        $user_id = Yii::$app->getRequest()->getbodyParam('user_id');
        $team_id = Yii::$app->getRequest()->getbodyParam('team_id');
        return $user->ChangeTeam($user_id,$team_id);
    }
}