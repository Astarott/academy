<?php
namespace common\models;

use app\models\Role;
use app\models\UserRole;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property integer $status
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string|null $phone
 * @property string|null $fio
 * @property int|null $age
 * @property string|null $study_place
 * @property string|null $experience
 * @property int|null $period
 * @property boolean|null $work_status
 * @property string|null $comment
 * @property int|null $last_point
 * @property Team[] $teams
 * @property UserAnswer[] $userAnswers
 * @property UserRole[] $userRoles
 * @property UserTeam[] $userTeams
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_REGISTER = 'Signupsecond';
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const STATUS_LEAD = 11;
    const STATUS_STUDENT = 12;
    const STATUS_MENTOR = 13;
    const STATUS_SUPERVISOR = 14;
    const STATUS_SUPERMENTOR = 15;
    public $password;
    public $role_id;
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'age', 'period', 'last_point'], 'default', 'value' => null],
            [['status', 'created_at', 'updated_at', 'age', 'period', 'last_point'], 'integer'],
            [['work_status'], 'boolean'],
            [['role_id'], 'integer'],
            [['email', 'password_reset_token', 'password_hash', 'phone', 'fio', 'study_place', 'experience', 'comment'], 'string', 'max' => 255],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED , self::STATUS_LEAD, self::STATUS_STUDENT, self::STATUS_MENTOR, self::STATUS_SUPERVISOR, self::STATUS_SUPERMENTOR]],
            [['age'], 'integer' , 'min' => 18, 'on' => self::SCENARIO_REGISTER],
            [['password'], 'string' , 'min' => 8, 'max'=> 30, 'on' => self::SCENARIO_REGISTER],
        ];
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['self::SCENARIO_REGISTER'] = ['age','password','email','role_id'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        $query = new Query();
        $query->select('user_id')->from('token')->where('token' == $token);
        return $user = $query->createCommand()->query()->read('user_id');
//        return static::findOne([
//            'verification_token' => $token,
//            'status' => self::STATUS_INACTIVE
//        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getVerificationToken()
    {
        $query = new Query();
        $query->select('token')->from('{{token}}')->where('user_id' == $this->id);
        $token = $query->createCommand()->query();
        return $token->read('token');
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function SignupSecond($_user){
        $_user->scenario = User::SCENARIO_REGISTER;
        $_user->age = $this->age;
        $_user->period = $this->period;
        $_user->comment = $this->comment;
        $_user->experience = $this->experience;
        $_user->last_point = $this->last_point;
        $_role = new UserRole();
        $_role->role_id = $this->role_id;
        $_role->user_id = $this->id;
        $_role->save();
        if ($_user->save() and $_role->save()){
            return [$_role, $_user];
        }
        return ['user' => $_user->getErrors(),'user_role' => $_role->getErrors()];
    }
}
