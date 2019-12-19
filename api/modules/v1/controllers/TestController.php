<?php


//namespace api\modules\v1\controllers;
namespace api\modules\v1\controllers;

use api\models\Test;
use app\models\UserAnswer;
use app\models\UserRole;
use common\models\User;
use Yii;
use yii\db\mssql\PDO;
use yii\db\Query;
use yii\rest\ActiveController;

class TestController extends ActiveController
{
    public $modelClass = Test::class;
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // НАследуем поведение родителя
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
        $actions = parent::actions();
        // отключить действия "delete" и "create" и "index"
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['delete']);
        unset($actions['update']);
        return $actions;
    }


    public function actionStartTest()
    {
        $token = Yii::$app->getRequest()->getQueryParam('token');
        $user_id = User::findByVerificationToken($token);
        if ($user_id == null) {
            return (['message' => 'Вы ввели неверный токен']);
        }
        $user_role = User::getLastRoleId($user_id);
        $query = new Query();
        $query->select(['question.id AS question_id', 'question.text AS question_text', 'answer.id AS answer_id', 'answer.text AS answer_text'])->from('{{answer}}')
            ->join('JOIN', '{{public.question}}', 'public.question.id = public.answer.question_id')
            ->join('JOIN', '{{public.test_question}}', 'public.test_question.question_id = public.question.id')
            ->join('JOIN', '{{public.test}}', 'public.test.id = public.test_question.test_id')
            ->where(['public.test.role_id' => $user_id])->all();
        $test = $query->createCommand()->query();
        return $test;
    }

    public function actionGetanswer(){
        $token = Yii::$app->getRequest()->getBodyParam('token');
        $answer = Yii::$app->getRequest()->getBodyParam('answer_id');
        $question = Yii::$app->getRequest()->getBodyParam('question_id');
        $user_id = User::findByVerificationToken($token);
        $user_answer = new UserAnswer();
        return $user_answer->saveuseranswer($user_id,$answer,$question);
    }

    public function actionCountTotalResult()
    {
        $token = Yii::$app->getRequest()->getQueryParam('token');

        $user_id = User::findByVerificationToken($token);
        if ($user_id == null) {
            return (['message' => 'Вы ввели неверный токен']);
        }

        $user_role = User::getLastRoleId($user_id);

        //Подсчет правильных ответов
        $query = new Query();
        $query->select(['question.id AS question_id', 'answer.id AS right_answer_id', 'user_id'])->from('answer')
            ->join('JOIN', '{{public.question}}', 'public.question.id = public.answer.question_id')
            ->join('INNER JOIN', '{{user_answer}}', 'user_answer.answer_id = answer.id')
            ->where(['answer.is_right' => true])
            ->andwhere(['user_id' => $user_id])
            ->all();
        $answer_count = $query->createCommand()->query()->count();

        //Подсчет вопросов
        $question_count = new Query();
        $question_count->select('question.id')->from('question')
            ->join('JOIN', '{{public.test_question}}', 'test_question.question_id = question.id')
            ->join('JOIN', '{{public.test}}', 'test.id = test_question.test_id')
            ->where(['test.role_id' => $user_role])
            ->all();
        $question_count = $question_count->createCommand()->query()->count();

        $result = round(($answer_count / $question_count) * 100);

        //Айдишник последней роли
        $user_role_query = new Query();
        $user_role_query->select('id')->from('user_role')->where(['role_id' => $user_role])
            ->orderBy('test_date DESC')->limit(1);
        $user_last_role = $user_role_query->createCommand()->query()->read()['id'];

        $temp = UserRole::findOne(['id' => $user_last_role]);

        $user = User::findOne(['id' => $user_id]);


        if ($temp->ChangeTotalResult($result) && $user->changeTotalResult($result) &&  $user->getTeam()){
            return ['message' => 'Все ответы записаны! Результаты подсчитаны! Команда присвоена'];
        }
        else {
            return ['message' => 'Неизвестная ошибка'];
        }
    }
}
