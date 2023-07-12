<?php

namespace app\models;

use Yii;

// /**
//  * This is the model class for table "{{%user}}".
//  *
//  * @property int $id
//  * @property string $user_name
//  * @property string $user_email
//  * @property string $password
//  * @property string $nick_name
//  * @property string|null $authKey
//  * @property string|null $accessToken
//  * @property string $date_created
//  */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
            [['user_name', 'user_email', 'nick_name'], 'required'],
            // [['password'], "required", "when" => function($model) { return $model->isNewRecord; }],
            [['password'], 'required', 'on' => 'register'],
            [['date_created','role_id'], 'safe'],
            [['user_name', 'user_email', 'nick_name'], 'string', 'max' => 32],
            [['password', 'authKey', 'accessToken'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'user_email' => 'User Email',
            'password' => 'Password',
            'nick_name' => 'Nick Name',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'date_created' => 'Date Created',
        ];
    }

        /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = User::findOne(['id' => $id]);
        // if(!$user){
        //     $user = User::findOne(['user_email' => $username]);
        // }
        if($user){
            return new static($user);
        }

        return null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = User::findOne(['user_name' => $username]);
        if(!$user){
            $user = User::findOne(['user_email' => $username]);
        }
        if($user){
            return new static($user);
        }
        
        /*
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }
        */

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {

        if (Yii::$app->getSecurity()->validatePassword($password, $this->password)) {
            return true;
        } else {
        }   return false;
        
        // return $this->password === $password;

    }

    // parent::beforeSave($insert)

    public function beforeSave($insert) {

        if ($this->isNewRecord) {
            $this->date_created = new yii\db\Expression('UTC_TIMESTAMP');
            $hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $this->password = $hash;

            $this->authKey = \Yii::$app->security->generateRandomString();
            $this->accessToken = \Yii::$app->security->generateRandomString();

        } else {
            //$this->updateDate = new CDbExpression('NOW()');
            $this->authKey = \Yii::$app->security->generateRandomString();
            $this->accessToken = \Yii::$app->security->generateRandomString();

        }

        return parent::beforeSave($insert);
    }

}

