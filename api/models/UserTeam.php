<?php

namespace app\models;
use common\models\User;
use Yii;

/**
 * This is the model class for table "user_team".
 *
 * @property int $id
 * @property int $user_id
 * @property int $team_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Team $team
 * @property User $user
 */
class UserTeam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'team_id'], 'required'],
            [['user_id', 'team_id'], 'default', 'value' => null],
            [['user_id', 'team_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID команды',
            'team_id' => 'ID команды',
            'created_at' => 'Дата создания команды',
            'updated_at' => 'Дата обновления команды',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function ChangeTeam($id,$team_id)
    {
            if($user_team = self::find()->where(['user_id' => $id])->one()){
            $user_team->team_id = $team_id;
            if ($user_team->save())
                return ['message' => $user_team->user_id.' теперь в команде '.$user_team->team_id];
            return ['user_team' => $this->getErrors()];}
            else {
                return ['message' => 'Несуществующая команда или пользователь'];
            }
    }
}
