<?php

namespace luya\smsnewsletter\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\ngrest\plugins\SelectRelationActiveQuery;

/**
 * Log Message Person.
 *
 * File has been created with `crud/create` command.
 *
 * @property integer $id
 * @property integer $person_id
 * @property integer $log_message_id
 * @property string $tracking_id
 * @property integer $timestamp
 */
class LogMessagePerson extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smsnewsletter_log_message_person';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-smsnewsletter-logmessageperson';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'person_id' => Yii::t('app', 'Person'),
            'log_message_id' => Yii::t('app', 'Log Message ID'),
            'tracking_id' => Yii::t('app', 'Tracking ID'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id', 'log_message_id', 'timestamp'], 'required'],
            [['person_id', 'log_message_id', 'timestamp'], 'integer'],
            [['tracking_id'], 'string', 'max' => 120],
            [['tracking_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['tracking_id'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'person_id' => ['class' => SelectRelationActiveQuery::class, 'query' => $this->getPerson(), 'labelField' => ['firstname', 'lastname']],
            'log_message_id' => ['class' => SelectRelationActiveQuery::class, 'query' => $this->getLogMessage(), 'labelField' => ['message']],
            'tracking_id' => 'text',
            'timestamp' => 'datetime',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['timestamp', 'person_id', 'tracking_id']],
            ['delete', false],
        ];
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, ['id' => 'person_id']);
    }

    public function getLogMessage()
    {
        return $this->hasOne(LogMessage::class, ['id' => 'log_message_id']);
    }
}
