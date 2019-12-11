<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['/v1/signup', 'token' => $user->getVerificationToken()]);
?>
Hello <?= $user->fio ?>,

Follow the link below to enter in academy:

<?= $verifyLink ?>
