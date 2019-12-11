<?php

namespace api\models;

use api\models\Token;

use common\models\User;
use Yii;
use yii\base\Model;

class SignupFullForm extends User
{
    //Есть в базе
    public $email;
    public $phone;
    public $fio;

    //Новые поля
    public $userRoles;
    public $password;
    public $age;
    public $experience;
    public $study_place;
    public $period;
    public $work_status;
    public $comment;
//    public $confirmed_password;

    private $_user;

    public function rules()
    {
        return [
            //Прописать всю валидацию
//            // username and password are both required
//            [['email', 'phone', 'fio'], 'required'],
//
//            ['email', 'trim'],
//            ['email', 'email'],
//            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
//            return ($_user->getErrors());
            return "NE PROSHLO";
        }

        $_user = User::findByEmail($this->email);
        $_user->status = User::STATUS_STUDENT;
        return ($_user);
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