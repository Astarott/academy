<?php

namespace api\models;

//use api\models\Token;

use common\models\User;
use Yii;

class SignupFullForm extends User
{
//    public $email;
//    public $phone;
//    public $fio;
//    public $





    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'phone', 'fio'], 'required'],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

        ];
    }

    public function signupfirst()
    {
        if (!$this->validate())
        {
            return null;
        }
        $user = new User();
        $user->status = User::STATUS_LEAD;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->fio = $this->fio;
        return $user->save() && $this->sendEmail($user);
    }


    public function signupfull()
    {
        if (!$this->validate())
        {
            return null;
        };
//        $user ->getuser();
//        $user->status = User::STATUS_LEAD;
//        $user->email = $this->email;
//        $user->phone = $this->phone;
//        $user->fio = $this->fio;
//        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
    //     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

//    /**
//     * @return Token|null
//     */
//    public function auth()
//    {
//        if ($this->validate())
//        {
//            $token = new Token();
//            $token->user_id = $this->getUser()->id;
//            $token->generateToken(time() + 3600 * 24);
//            return $token->save() ? $token : null;
//        } else {
//            return null;
//        }
//    }
//    /**
//     * Finds user by [[username]]
//     *
//     * @return User|null
//     */
//    protected function getUser()
//    {
//        if ($this->_user === null) {
//            $this->_user = User::findByUsername($this->username);
//        }
//
//        return $this->_user;
//    }
}