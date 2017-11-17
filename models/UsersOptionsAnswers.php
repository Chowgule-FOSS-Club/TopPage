<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_options_answers".
 *
 * @property integer $uid
 * @property integer $qid
 * @property integer $oid
 * @property string $flag
 *
 * @property Options $o
 * @property Questions $q
 * @property Users $u
 */
class UsersOptionsAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_options_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'qid', 'oid', 'flag'], 'required'],
            [['uid', 'qid', 'oid'], 'integer'],
            [['flag'], 'string'],
            [['oid'], 'exist', 'skipOnError' => true, 'targetClass' => Options::className(), 'targetAttribute' => ['oid' => 'oid']],
            [['qid'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::className(), 'targetAttribute' => ['qid' => 'qid']],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['uid' => 'uid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'qid' => 'Qid',
            'oid' => 'Oid',
            'flag' => 'Flag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getO()
    {
        return $this->hasOne(Options::className(), ['oid' => 'oid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQ()
    {
        return $this->hasOne(Questions::className(), ['qid' => 'qid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(Users::className(), ['uid' => 'uid']);
    }

    

}
