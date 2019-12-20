<?php

namespace api\models;

//use common\models\query\PostQuery;
use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $expired_at
 * @property string $token
 */
class Token extends ActiveRecord implements IdentityInterface
{
    public function rules()
    {
        return [
            [['token',], 'string',],
            [['user_id'], 'integer'],
        ];
    }
    public static function tableName()
    {
        return '{{%token}}';
    }
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return Token::findOne(['token' => $token]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email,]);
    }


    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function generateToken($expire)
    {
        $this->expired_at = $expire;
        $this->token = \Yii::$app->security->generateRandomString();
    }

    public function getToken()
    {
        $this->token;
    }
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    public function fields()
    {
        return [
            'token' => 'token',
            'expired' => function () {
                return date(DATE_RFC3339, $this->expired_at);
            },
        ];
    }
    public function Getauthtoken(){
        if (isset($_SERVER['HTTP_AUTHORIZATION'])){
        $auth_token = $_SERVER['HTTP_AUTHORIZATION'];
        preg_match('/Bearer\s(\S+)/', $auth_token, $matches);
        return $matches[1];}
        else {
            return ['message' => 'Для авторизации необходмио передать HTTP_AUTHORIZATION'];
        }
    }
}
