<?php

namespace luya\smsnewsletter\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

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
            'list_id' => Yii::t('app', 'List ID'),
            'message' => Yii::t('app', 'Message'),
            'timestamp' => Yii::t('app', 'Timestamp'),
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
            'list_id' => 'number',
            'message' => 'textarea',
            'origin' => 'text',
            'timestamp' => 'number',
            'admin_user_id' => 'number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['list_id', 'message', 'timestamp', 'admin_user_id', 'origin']],
            [['create', 'update'], ['list_id', 'message', 'timestamp', 'admin_user_id', 'origin']],
            ['delete', false],
        ];
    }
    
    public function getLogMessagePersons()
    {
        return $this->hasMany(LogMessagePerson::class, ['log_message_id' => 'id']);
    }
}