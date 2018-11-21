<?php

namespace luya\smsnewsletter\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\models\User;
use luya\admin\ngrest\plugins\SelectRelationActiveQuery;

/**
 * Log Message.
 *
 * File has been created with `crud/create` command.
 *
 * @property integer $id
 * @property integer $list_id
 * @property text $message
 * @property integer $timestamp
 * @property integer $admin_user_id
 * @property string $origin
 */
class LogMessage extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smsnewsletter_log_message';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-smsnewsletter-logmessage';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'list_id' => Yii::t('app', 'List'),
            'message' => Yii::t('app', 'Message'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'admin_user_id' => Yii::t('app', 'User')
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['list_id', 'message', 'timestamp'], 'required'],
            [['list_id', 'timestamp', 'admin_user_id'], 'integer'],
            [['message', 'origin'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['message'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'list_id' => ['class' => SelectRelationActiveQuery::class, 'query' => $this->getList(), 'labelField' => ['title']],
            'message' => 'textarea',
            'origin' => 'text',
            'timestamp' => 'datetime',
            'admin_user_id' => ['class' => SelectRelationActiveQuery::class, 'query' => $this->getAdminUser(), 'labelField' => ['firstname', 'lastname']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['list_id', 'timestamp', 'message', 'admin_user_id']],
            ['delete', false],
        ];
    }
    
    public function getLogMessagePersons()
    {
        return $this->hasMany(LogMessagePerson::class, ['log_message_id' => 'id']);
    }

    public function getList()
    {
        return $this->hasOne(ListModel::class, ['id' => 'list_id']);
    }

    public function getAdminUser()
    {
        return $this->hasOne(User::class, ['id' => 'admin_user_id']);
    }
}
