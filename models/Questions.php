<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property integer $qid
 * @property string $name
 *
 * @property UsersOptionsAnswers[] $usersOptionsAnswers
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qid' => 'Qid',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersOptionsAnswers()
    {
        return $this->hasMany(UsersOptionsAnswers::className(), ['qid' => 'qid']);
    }

    public function getOptions()
    {
        return $this->hasMany(Options::className(), ['oid' => 'oid'])->viaTable('users_options_answers', ['qid' => 'qid']);
    }
}
