<?php


namespace api\models;

use api\models\Token;

use common\models\User;
use Yii;

class SignupForm extends User
{
    public $email;
    public $phone;
    public $fio;

    private $_user;
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

    public function signup()
    {
        if (!$this->validate())
        {
            return null;
        }
        $_user = new User();
        $_user->status = User::STATUS_LEAD;
        $_user->email = $this->email;
        $_user->phone = $this->phone;
        $_user->fio = $this->fio;

        return $_user->save() && $this->generateTokenToUser();
//        return $user->save() && $this->sendEmail($user);
    }

//    /**
//     * Sends confirmation email to user
//     * @param User $user user model to with email should be send
//     * @return bool whether the email was sent
//     */
//    protected function sendEmail($user)
//    {
//        return Yii::$app
//            ->mailer
//            ->compose(
//                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
//                ['user' => $user]
//            )
//            ->setFrom([Yii::$app->params['email'] => 'Письмо с сайта'])
//            ->setTo($this->email)
//            ->setSubject('Account registration at ' . Yii::$app->name)
//            ->send();
//    }

    /**
     * @return Token|null
     */
    protected function generateTokenToUser()
    {
            $token = new Token();
            $token->user_id = $this->getUser()->id;
            $token->generateToken(time() + 3600 * 24);
            return $token->save() ? $token : null;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }
        return $this->_user;
    }

}