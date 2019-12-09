<?php


namespace api\models;

//use api\models\Token;

use common\models\User;
use yii\base\Model;

class SignupForm extends User
{
    public $email;
    public $phone;
    public $fio;

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
        if (!$this->validate()) {
            return null;
        }

//        $model = new User();
//        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        $user = new User();
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->fio = $this->fio;
        return ($user);
//        $user->save() && $this->sendEmail($user);

        return $user->save() && $this->sendEmail($user);
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