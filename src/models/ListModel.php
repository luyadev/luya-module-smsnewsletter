<?php

namespace luya\smsnewsletter\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\smsnewsletter\admin\aws\SmsActiveWindow;
use luya\smsnewsletter\admin\Module;

/**
 * List.
 * 
 * Using ListModel instead of List as list is a php reserved word.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property string $title
 */
class ListModel extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smsnewsletter_list';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-smsnewsletter-list';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Module::t('sms.model.listmodel.title'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['title'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'title' => 'text',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['title']],
            [['create', 'update'], ['title']],
            ['delete', false],
        ];
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \luya\admin\ngrest\base\NgRestModel::ngRestActiveWindows()
     */
    public function ngRestActiveWindows()
    {
        return [
            ['class' => SmsActiveWindow::class], 
        ];
    }
    
    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getLogMessages()
    {
        return $this->hasMany(LogMessage::class, ['list_id' => 'id']);
    }

    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getPersons()
    {
        return $this->hasMany(Person::class, ['id' => 'person_id'])->viaTable(ListPersonRef::tableName(), ['list_id' => 'id']);
    }
}