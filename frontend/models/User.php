<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string|null $password_reset_token
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $phone
 * @property string|null $fio
 * @property int|null $age
 * @property string|null $study_place
 * @property string|null $experience
 * @property int|null $period
 * @property string|null $work_statusb
 * @property string|null $comment
 * @property int|null $last_point
 * @property string|null $verification_token
 *
 * @property Team[] $teams
 * @property UserAnswer[] $userAnswers
 * @property UserRole[] $userRoles
 * @property UserTeam[] $userTeams
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'auth_key', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at', 'age', 'period', 'last_point'], 'default', 'value' => null],
            [['status', 'created_at', 'updated_at', 'age', 'period', 'last_point'], 'integer'],
            [['username', 'email', 'password_hash', 'password_reset_token', 'phone', 'fio', 'study_place', 'experience', 'work_status', 'comment', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'phone' => 'Phone',
            'fio' => 'Fio',
            'age' => 'Age',
            'study_place' => 'Study Place',
            'experience' => 'Experience',
            'period' => 'Period',
            'work_status' => 'Work Status',
            'comment' => 'Comment',
            'last_point' => 'Last Point',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeams()
    {
        return $this->hasMany(Team::className(), ['creator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAnswers()
    {
        return $this->hasMany(UserAnswer::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTeams()
    {
        return $this->hasMany(UserTeam::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\query\UserQuery(get_called_class());
    }
}
