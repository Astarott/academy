<?php

namespace app\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "user_answer".
 *
 * @property int $id
 * @property int $user_id
 * @property int $answer_id
 * @property int $question_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Answer $answer
 * @property Question $question
 * @property User $user
 */
class UserAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'answer_id', 'question_id'], 'required'],
            [['user_id', 'answer_id', 'question_id'], 'default', 'value' => null],
            [['user_id', 'answer_id', 'question_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Answer::className(), 'targetAttribute' => ['answer_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
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
            'user_id' => 'User ID',
            'answer_id' => 'Answer ID',
            'question_id' => 'Question ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function saveuseranswer($user_id,$answer_id,$question_id){
        $this->answer_id = $answer_id;
        $this->user_id = $user_id;
        $this->question_id = $question_id;
        if ($this->save()){
            return ['message' => 'Ответ успешно сохранён!'];
        }
        return ['message' => $this->getErrors()];
    }

}
