<?php

namespace common\models;

use api\models\Token;
use app\models\Role;
use app\models\Team;
use app\models\UserAnswer;
use app\models\UserRole;
use app\models\UserTeam;
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
 * @property string $role_name write-only role_name
 * @property string $role_id write-only role_id
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
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_SIGNUP = 'signup';
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
    public $role_name;

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
            [['password'], 'string'],
            [['role_name'], 'string'],
            [['email', 'password_reset_token', 'password_hash', 'phone', 'fio', 'study_place', 'experience', 'comment'], 'string', 'max' => 255],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED, self::STATUS_LEAD, self::STATUS_STUDENT, self::STATUS_MENTOR, self::STATUS_SUPERVISOR, self::STATUS_SUPERMENTOR]],
            [['age'], 'integer', 'min' => 18, 'on' => self::SCENARIO_REGISTER, 'message' => 'Значение поля Возраст должен не мение 18'],
            [['age', 'role_name', 'password', 'experience'], 'required', 'on' => self::SCENARIO_REGISTER, 'message' => 'Укажите {attribute}'],
            [['password'], 'string', 'min' => 8, 'on' => self::SCENARIO_REGISTER],
            [['password'], 'string', 'max' => 30, 'on' => self::SCENARIO_REGISTER],
            [['work_status'], 'boolean', 'on' => self::SCENARIO_REGISTER],
            [['email'], 'string',  'on' => self::SCENARIO_LOGIN],
            [['password','password_hash'], 'string', 'on' => self::SCENARIO_LOGIN],
            [['phone','email','fio'], 'string', 'on' => self::SCENARIO_SIGNUP],
            [['email'], 'unique', 'on' => self::SCENARIO_SIGNUP],
            [['email'], 'email', 'on' => self::SCENARIO_SIGNUP]
        ];
    }
    public function attributeLabels()
    {
        return [
            'email' => 'почта',
            'password_hash' => 'хэш пароля',
            'password' => 'пароль',
            'experience' => 'опыт',
            'role_name' => 'роль',
            'comment' => 'комментарий',
            'age' => 'возраст',
            'phone' => 'номер телефон',
        ];
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['self::SCENARIO_REGISTER'] = ['age', 'password', 'email', 'role_id', 'period', 'experience', 'role_name', 'comment','work_status'];
        $scenarios['self::SCENARIO_LOGIN'] = ['password', 'email', 'password_hash'];
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

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        $query = new Query();
        $query->select('user_id')->from('token')->where(['token' => $token]);
        return $user = $query->createCommand()->query()->read()['user_id'];
    }

    public static function getLastRoleId($user_id)
    {
        $query = new Query();
        $query->select(['role_id', 'test_date'])->from('user_role')->where(['user_id' => $user_id])->all();
        $query->orderBy('test_date DESC')->limit(1);
        $role_id = $query->createCommand()->query();
//        $query->orderBy('test_date')->limit(1);
        return $role_id->read('role_id')['role_id'];
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

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
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
        $query->select('token')->from('{{token}}')->where(['user_id' => $this->id]);
        $token = $query->createCommand()->query();
        return $token->read('token')['token'];
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

    public function signup()
    {
        $this->status = User::STATUS_LEAD;
        $this->validate();
        if ($this->save() &&  $this->generateTokenToUser()) {
            return ['message' => 'Вы успешно зарегистрированны'];
        }
        else {
            return $this->getErrors();
        }
    }
    protected function generateTokenToUser()
    {
        $token = new Token();
        $token->user_id = $this->id;
        $token->generateToken(time() + 3600 * 24);
        return $token->save() ? $token : false;
    }

    public function SignupSecond()
    {
        $this->scenario = User::SCENARIO_REGISTER;
        $this->setPassword($this->password);
        if (!Role::findOne(['name' => $this->role_name])) {
            return ['message' => 'роли ' . $this->role_name . ' не существует'];
        }
        $_role_name = Role::findOne(['name' => $this->role_name]);
        $_role = new UserRole();
        $_role->role_id = $_role_name->id;
        $_role->user_id = $this->id;
        $_role->test_date = date("Y-m-d H:i:s");
        if ($this->save() and $_role->save()) {
            return ['message' => 'Регистрация прошла успешно!'];
        }
        return ['user' => $this->getErrors(), 'user_role' => $_role->getErrors()];
    }

    public function changeTotalResult($result)
    {
        $this->last_point = $result;
        $this->status = User::STATUS_STUDENT;
        if ($this->save())
            return 'true';
        return false;
    }
    public function getTeam(){
        //Получаем роль студента
        $query = new Query();
        $query->select(['role_id'])
            ->from('{{user_role}}')
            ->where(['user_id' => $this->id])
            ->one();
        $test = $query->createCommand()->query()->read()['role_id'];

        //Получаю айдишники команд с такой же ролью
        $find_like_teams = new Query();
        $find_like_teams->select('*')->from('user_role')->where(['role_id' => $test])
            ->join('JOIN','{{public.user_team}}','user_team.user_id = user_role.user_id')
            ->all();
        $answer_count = $find_like_teams->createCommand()->query();

        //Создаём массив команд с одинаковой ролью
        $array = [];

        //Добавляем комманду в массив
        foreach ($answer_count as $item){
            array_push($array,$item['team_id']);
        }
        //получаем весь список комманд
        $another = new Query();
        $another->select('*')->from('team')->where(['inSet' => false])
            ->all();
        $answ = $another->createCommand()->query();

        $teamadd = new UserTeam();
        //Добавляем студента в команду где нет такой же роли как у студента
        foreach ($answ as $item){
            while (!in_array($item['id'], $array)){
                $teamadd->user_id = $this->id;
                $teamadd->team_id = $item['id'];
                return $teamadd->save();
            };
        }
        $teamadd->user_id = $this->id;
        $teamadd->team_id = 21;
        return $teamadd->save();
    }

    public function login()
    {
        $this->scenario = User::SCENARIO_LOGIN;
        $this->validate();
        if ($this->validate()){
        if (User::findOne(['email' => $this->email])){
            $user = User::findOne(['email' => $this->email]);
            if (Yii::$app->security->validatePassword($this->password, $user->password_hash)){
                $user_token = Token::findOne(['user_id' => $user->id]);
                $user_token->token = Yii::$app->security->generateRandomString();
                $user_token->save();
                return ['token' => $user_token->token];
            }
            else {
                return ['message' => 'пароль или логин не совпадает'];
            }
        }
        else {
            return ['message' => 'пароль или логин не совпадает'];
        }
    }
    else {
        return $this->getErrors();
    }
    }

}
