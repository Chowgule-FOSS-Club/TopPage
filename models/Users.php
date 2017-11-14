<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $uid
 * @property string $email
 * @property string $password
 *
 * @property UsersQuestionsAnswers[] $usersQuestionsAnswers
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'string', 'max' => 60],
            ['email', 'email'],
            [['password'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->uid;
    }

    public function getAuthKey()
    {
        return 0;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['email'=>$username]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersQuestionsAnswers()
    {
        return $this->hasMany(UsersQuestionsAnswers::className(), ['uid' => 'uid']);
    }

    
}
