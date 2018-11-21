<?php

namespace luya\smsnewsletter\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * List Person Ref.
 *
 * File has been created with `crud/create` command.
 *
 * @property integer $person_id
 * @property integer $list_id
 */
class ListPersonRef extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smsnewsletter_list_person_ref';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-smsnewsletter-listpersonref';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'person_id' => Yii::t('app', 'Person ID'),
            'list_id' => Yii::t('app', 'List ID'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id', 'list_id'], 'required'],
            [['person_id', 'list_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'person_id' => 'number',
            'list_id' => 'number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['person_id', 'list_id']],
            [['create', 'update'], ['person_id', 'list_id']],
            ['delete', false],
        ];
    }
}
