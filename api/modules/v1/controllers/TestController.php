<?php


//namespace api\modules\v1\controllers;
namespace api\modules\v1\controllers;

use api\models\Test;
use common\models\User;
use Yii;
use yii\db\Query;
use yii\rest\ActiveController;

class TestController extends ActiveController
{
    public  $modelClass = Test::class;

    public function actionIndex()
    {
        return "hello there!";
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
//        $query->select(['question_id','question.text','answer_id','answer.text'])->from('answer')->join('JOIN','question')->on()
        $query->select(['question.id AS question_id', 'question.text AS question_text', 'answer.id AS answer_id', 'answer.text AS answer_text'])->from('{{answer}}')
            ->join('JOIN', '{{public.question}}', 'public.question.id = public.answer.question_id')
            ->join('JOIN', '{{public.test_question}}', 'public.test_question.question_id = public.question.id')
            ->join('JOIN', '{{public.test}}', 'public.test.id = public.test_question.test_id')
            ->where(['public.test.role_id' => $user_role])->all();
        $test = $query->createCommand()->query();
        return $test;
//            return ['message' => 'Разрешены только GET запросы'];

    }
}
