<?php


//namespace api\modules\v1\controllers;
namespace frontend\controllers;

use frontend\models\Test;
use yii\rest\ActiveController;

class TestController extends ActiveController
{
    public  $modelClass = Test::class;
}
