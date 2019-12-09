<?php

namespace frontend\models;

use frontend\models\query\TestQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%test}}".
 *
 * @property int $id
 * @property int $role_id
 *
 * @property Role $role
 * @property TestQuestion[] $testQuestions
 * @property Question[] $questions
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id'], 'required'],
            [['role_id'], 'default', 'value' => null],
            [['role_id'], 'integer'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTestQuestions()
    {
        return $this->hasMany(TestQuestion::className(), ['test_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])->viaTable('{{%test_question}}', ['test_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestQuery(get_called_class());
    }
}
