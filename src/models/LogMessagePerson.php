<?php

namespace luya\smsnewsletter\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

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
            'person_id' => Yii::t('app', 'Person ID'),
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
            'person_id' => 'number',
            'log_message_id' => 'number',
            'tracking_id' => 'text',
            'timestamp' => 'number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['person_id', 'log_message_id', 'tracking_id', 'timestamp']],
            [['create', 'update'], ['person_id', 'log_message_id', 'tracking_id', 'timestamp']],
            ['delete', false],
        ];
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, ['id' => 'person_id']);
    }
}