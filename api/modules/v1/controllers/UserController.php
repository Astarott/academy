<?php

namespace api\modules\v1\controllers;

use api\models\SignupForm;
use api\models\Token;
use app\models\UserTeam;
use app\models\Team;
use common\models\User;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\ServerErrorHttpException;

class UserController extends ActiveController
{
    public $modelClass = User::class;

    public function beforeAction($action)
    {
//        return true;
    }

    public function behaviors()
    {

        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {

            Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT');

            Yii::$app->end();

        }

        $behaviors = parent::behaviors();

        # Наследуем поведение родителя
        $behaviors['authenticator'] = [
            'class' =>  HttpBearerAuth::className(),
            //  действия "update" только для авторизированных пользователей
            'only'=>[
                'get-user',
                'get-all-students',
                'get-all-students-in-set',
                'send-mails',
                'change-team',
                'disband-team',
                'change-status-team'
            ]
        ];
        $behaviors['authenticator']['except'] = ['options'];



        $behaviors['contentNegotiator']=[
            'class' => \yii\filters\ContentNegotiator::class,
            'formatParam' => '_format',
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        return [];
    }

    protected function verbs()
    {
        return [
            'index' => ['GET', 'OPTIONS'],
            'login' => ['POST', 'OPTIONS'],
            'signUp' => ['POST','OPTIONS'],
            'getAllStudents' => ['GET', 'OPTIONS'],
            'getAllStudentsInSet' => ['GET','OPTIONS'],
            'sendMails' => ['POST','OPTIONS'],
            'signUpSecond' => ['GET','POST','OPTIONS'],
            'changeTeam' => ['POST','OPTIONS'],
            'changeStatusTeam' => ['POST','OPTIONS'],
            'disbandTeam' => ['POST','OPTIONS'],
            'sendToken' => ['POST','OPTIONS'],
        ];
    }

    public function actionIndex(){
        return 'Ваша api работает!';
    }

    public function actionSignUp()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_SIGNUP;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        return $model->signup();
    }

    public function actionGetAllStudents()
    {
        \Yii::$app->response->format = 'json';
        $gettoken = new Token();
        $token = $gettoken->Getauthtoken();
        $user = $gettoken->findIdentityByAccessToken($token);
        if ($gettoken->findIdentityByAccessToken($token) && $user->id == 5){
            $query = new Query();
            $query->select(['user.id', 'user.fio', 'role.name AS role', 'team.id AS team_id', 'team.name AS team_name', 'last_point'])
                ->from('{{user}}')
                ->join('FULL JOIN', '{{public.token}}', 'public.user.id = public.token.user_id')
                ->join('FULL JOIN', '{{public.user_role}}', 'public.user.id = public.user_role.user_id')
                ->join('FULL JOIN', '{{public.role}}', 'public.user_role.role_id = public.role.id')
                ->join('FULL JOIN', '{{public.user_team}}', 'public.user.id = public.user_team.user_id')
                ->join('FULL JOIN', '{{public.team}}', 'public.user_team.team_id = public.team.id')
                ->where(['public.user.status' => 12])
                ->andWhere(['public.team.inSet' => 'false'])
                ->orderBy('role')
                ->all();
            $command = $query->createCommand();
            $resp = $command->query();
            return $resp;
        }
        else {
            return ['message' => 'нет прав!'];
        }
    }


    public function actionGetAllStudentsInSet()
    {
        $gettoken = new Token();
        $token = $gettoken->Getauthtoken();
        $user = $gettoken->findIdentityByAccessToken($token);

        if ($gettoken->findIdentityByAccessToken($token) && $user->id == 5){
            $query = new Query();
            $query->select(['user.id', 'user.fio', 'role.name AS role', 'team.id AS team_id', 'team.name AS team_name', 'last_point'])->from('{{user}}')
                ->join('FULL JOIN', '{{public.token}}', 'public.user.id = public.token.user_id')
                ->join('FULL JOIN', '{{public.user_role}}', 'public.user.id = public.user_role.user_id')
                ->join('FULL JOIN', '{{public.role}}', 'public.user_role.role_id = public.role.id')
                ->join('FULL JOIN', '{{public.user_team}}', 'public.user.id = public.user_team.user_id')
                ->join('FULL JOIN', '{{public.team}}', 'public.user_team.team_id = public.team.id')
                ->where(['public.user.status' => 12])->andWhere(['public.team.inSet' => 'true'])->orderBy('role')->all();
            $command = $query->createCommand();
            $resp = $command->query();
            return $resp;
        }
        else {
            return ['message' => 'нет прав!'];
        }
    }

    public function actionSendMails()
    {
        $gettoken = new Token();
        $token = $gettoken->Getauthtoken();
        $user = $gettoken->findIdentityByAccessToken($token);
        if ($gettoken->findIdentityByAccessToken($token) && $user->id == 5){
            $query = new Query();
            $query->select('user.email')->from('{{user}}')->where(['user.status' => User::STATUS_LEAD])->all();
            $command = $query->createCommand()->query();
            foreach ($command as $item) {
                $mail = $item["email"];
                $users = User::findOne(["email" => $mail]);
                $verifyLink = \yii\helpers\Url::to('http://localhost:8080/studentRegistration?token='.$users->getVerificationToken());
                if (!$this->sendEmail($users,$verifyLink)) {
                    return ['message' => 'Сообщение пользователю с ' . $mail . ' почтой не отправилось'];
                }
            }
            return (['massage' => 'Сообщения были отправлены']);
        }
        else {
            return ['message' => 'нет прав!'];
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */

    protected function sendEmail($user,$verifyLink)
    {

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user,'verifyLink' => $verifyLink]
            )
            ->setFrom([Yii::$app->params['email'] => 'Ссылка на сайт'])
            ->setTo($user->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

    public function actionSignUpSecond()
    {
        $token = Yii::$app->getRequest()->getBodyParam('token');
        $user_id = User::findByVerificationToken($token);
        if ($user_id == null) {
            return (['message' => 'Вы ввели неверный токен']);
        }
//        if (Yii::$app->getRequest()->isPost) {
        $user = User::findOne(['id' => $user_id]);
        $user->load(Yii::$app->getRequest()->getBodyParams(), '');
        return ($user->SignupSecond());
//        } elseif (Yii::$app->getRequest()->isGet) {
//            $query = new Query();
//            $query->select(['fio', 'email', 'phone', 'token.token'])->
//            from('{{user}}')->where(['user.id' => $user_id])
//                ->join('JOIN', '{{public.token}}', 'public.token.user_id = public.user.id')
//                ->one();
//            $command = $query->createCommand();
//            $resp = $command->query();
//            return $resp;
//        } else {
//            return ['message' => 'Разрешены только GET и POST запросы'];
//        }
    }

    public function actionGetUser()
    {
        $gettoken = new Token();
        $token = $gettoken->Getauthtoken();
        $user = $gettoken->findIdentityByAccessToken($token);
        if ($user->id == 5 and $gettoken->findIdentityByAccessToken($token) ){
            $id = Yii::$app->getRequest()->getQueryParam('id');
            $query = new Query();
            $query->select(['user.id', 'user.fio', 'user.age', 'user.experience', 'user.study_place', 'user.period', 'role.name AS role', 'team.name AS team_name', 'last_point', 'email'])->from('{{user}}')
                ->join('FULL JOIN', '{{public.token}}', 'public.user.id = public.token.user_id')
                ->join('FULL JOIN', '{{public.user_role}}', 'public.user.id = public.user_role.user_id')
                ->join('FULL JOIN', '{{public.role}}', 'public.user_role.role_id = public.role.id')
                ->join('FULL JOIN', '{{public.user_team}}', 'public.user.id = public.user_team.user_id')
                ->join('FULL JOIN', '{{public.team}}', 'public.user_team.team_id = public.team.id')
                ->where(['public.user.id' => $id])->orderBy('role')->one();
            $command = $query->createCommand();
            $resp = $command->query();
            return $resp;
        }
        else {
            return ['message' => 'нет прав!'];
        }
    }

    public function actionChangeTeam()
    {
        $gettoken = new Token();
        $token = $gettoken->Getauthtoken();
        $user = $gettoken->findIdentityByAccessToken($token);
        if ($user->id == 5 and $gettoken->findIdentityByAccessToken($token) ){
            $user = new UserTeam();
            $user_id = Yii::$app->getRequest()->getbodyParam('user_id');
            $team_id = Yii::$app->getRequest()->getbodyParam('team_id');
            return $user->ChangeTeam($user_id, $team_id);
        }
        else {
            return ['message' => 'нет прав!'];
        }
    }

    public function actionChangeStatusTeam()
    {
        $gettoken = new Token();
        $token = $gettoken->Getauthtoken();
        $user = $gettoken->findIdentityByAccessToken($token);
        if ($user->id == 5 and $gettoken->findIdentityByAccessToken($token) ){
            $team_id = Yii::$app->getRequest()->getbodyParam('team_id');
            $team = Team::find()->where(['id' => $team_id])->one();
            return $team->ChangeStatusTeam();
        }
        else {
            return ['message' => 'нет прав!'];
        }
    }

    public function actionDisbandTeam()
    {
        $gettoken = new Token();
        $token = $gettoken->Getauthtoken();
        $user = $gettoken->findIdentityByAccessToken($token);
        if ($user->id == 5 and $gettoken->findIdentityByAccessToken($token) )
        {
            $team_id = Yii::$app->getRequest()->getbodyParam('team_id');
            $team = Team::find()->where(['id' => $team_id])->one();
            return $team->Disbandteam();
        }
        else {
            return ['message' => 'нет прав!'];
        }
    }
    public function actionLogin()
    {
        $user = new User();
        $user->load(Yii::$app->getRequest()->getBodyParams(), '');
        return $user->login();
    }
    public function actionSendToken()
    {
        $token = Yii::$app->getRequest()->post('token');
        $query = new Query();
        if($query->select(['user.phone', 'user.fio', 'user.email'])->from('{{token}}')
            ->join('JOIN', '{{public.user}}', 'public.user.id = public.token.user_id')
            ->where(['public.token.token' => $token])
            ->one())
        {
            $command = $query->createCommand();
            $resp = $command->query();
            return $resp;
        }
        else {
            return ['message' => 'Токен не валидный'];
        }
    }
}