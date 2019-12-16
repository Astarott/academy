<?php

namespace app\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $project
 * @property bool $inSet
 * @property int|null $creator_id
 *
 * @property User $creator
 * @property UserTeam[] $userTeams
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inSet'], 'boolean'],
            [['creator_id'], 'default', 'value' => null],
            [['creator_id'], 'integer'],
            [['name', 'project'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название команды',
            'project' => 'Проект Команды',
            'inSet' => 'Сформированная команда',
            'creator_id' => 'Создатель команды',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTeams()
    {
        return $this->hasMany(UserTeam::className(), ['team_id' => 'id']);
    }
    public function ChangeStatusTeam(){
        if ($this->inSet == false){
            $this->inSet = true;
            $this->save();
            return ['message' => 'Команда сформирована!'];
        }
        elseif ($this->inSet == true) {
            return ['message' => 'Команда уже сформирована!'];
        }
        else {
            return ['message' => $this->getErrors()];
        }
    }
    public function Disbandteam()
    {
        $students = UserTeam::find()->where(['team_id' => $this->id])->all();
        if ($this->id == 21){
            return ['message' => 'Эту команду нельзя забанить'];
        }
        foreach ($students as $item){
            $student = UserTeam::findOne(['user_id' =>$item['user_id']]);
            $student->team_id = 21;
            $student->save();
        }
        $this->inSet = false;
        $this->save();
        return ['message' => 'Команда забанена!'];
    }

}
