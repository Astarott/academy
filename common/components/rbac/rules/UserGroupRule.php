<?php
namespace common\components\rbac\rules;
use Yii;
use yii\rbac\Rule;

class UserGroupRule extends Rule
{
    public $name = 'userGroup';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $group = Yii::$app->user->identity->group;
            if ($item->name === 'admin') {
                return $group == 'admin';
            } elseif ($item->name === 'supermentor') {
                return $group == 'admin' || $group == 'supermentor';
            } elseif ($item->name === 'mentor') {
                return $group == 'admin' || $group == 'supermentor' || $group == 'mentor';
            } elseif ($item->name === 'supervisor') {
                return $group == 'admin' || $group == 'supermentor' || $group == 'supervisor';
            } elseif ($item->name === 'student') {
                return $group == 'student' || $group == 'admin' || $group == 'lead';
            }
            elseif ($item->name === 'lead') {
                return $group == 'admin' || $group == 'lead';
            }
        }
        return true;
    }
}
