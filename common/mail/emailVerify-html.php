<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$verifyLink = \yii\helpers\Url::to('http://localhost:8080/studentRegistration?token='.$user->getVerificationToken());
//$verifyLink = (['http://localhost:8081/studentRegistration', 'token' => $user->getVerificationToken()]);


?>

<div class="verify-email">
    <p>Hello <?= Html::encode($user->fio) ?>,</p>

    <p>Follow the link below to verify your email:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>