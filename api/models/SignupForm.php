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


    /**
     * @return Token|null
     */

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */


}