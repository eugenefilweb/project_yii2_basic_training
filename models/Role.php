<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%role}}".
 *
 * @property int $id
 * @property string $role_name
 * @property string $access_role
 * @property string $date_created
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%role}}';
    }

    /**
     * {@inheritdoc}
     */

    
    public $role_list;
    public function rules()
    {
        return [
            [['role_name', 'access_role'], 'required'],
            [['access_role'], 'string'],
            [['date_created'], 'safe'],
            [['role_name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'access_role' => 'Access Role',
            'date_created' => 'Date Created',
        ];
    }

    public function beforeSave($insert) {

        if ($this->isNewRecord) {
            $this->date_created = new yii\db\Expression('UTC_TIMESTAMP');

        } else {

        }

        return parent::beforeSave($insert);
    }
}
