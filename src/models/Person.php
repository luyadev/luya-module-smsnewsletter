<?php

namespace luya\smsnewsletter\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\traits\SoftDeleteTrait;
use luya\admin\ngrest\plugins\CheckboxRelationActiveQuery;
use libphonenumber\PhoneNumberUtil;
use luya\smsnewsletter\admin\Module;

/**
 * Person.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property integer $phone
 * @property tinyint $is_deleted
 */
class Person extends NgRestModel
{
    use SoftDeleteTrait;
    
    public $adminLists = [];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smsnewsletter_person';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-smsnewsletter-person';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_BEFORE_VALIDATE, function() {
            $this->phone = $this->parsePhoneNumberToRegion($this->phone);
        });
    }
    
    /**
     * 
     * @param string $numberToParse
     * @return string
     */
    public function parsePhoneNumberToRegion($numberToParse)
    {
        $number = PhoneNumberUtil::getInstance()->parse($numberToParse, strtoupper(Module::getInstance()->defaultNumberRegion));
        
        return $number->getCountryCode() . $number->getNationalNumber();
    }
    
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\Model::attributeHints()
     */
    public function attributeHints()
    {
        $defaultRegion = Module::getInstance()->defaultNumberRegion;
        return [
            'phone' => $defaultRegion ? "If the numbers are entered without nationl prefix, national prefix '{$defaultRegion}' will be used." : 'Enter the phone numbers with national prefix like +41 79 123 45 65',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'phone' => Yii::t('app', 'Phone'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'adminLists' => 'Lists',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'phone'], 'required'],
            [['phone'], 'integer'],
            [['firstname', 'lastname'], 'string', 'max' => 255],
            [['is_deleted'], 'boolean'],
            [['adminLists'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['firstname', 'lastname'];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'firstname' => 'text',
            'lastname' => 'text',
            'phone' => 'text',
            'is_deleted' => 'number',
        ];
    }
    
    public function ngRestExtraAttributeTypes()
    {
        return [
            'adminLists' => [
                'class' => CheckboxRelationActiveQuery::class,
                'query' => $this->getLists(),
                'labelField' => ['title'],
            ],  
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['firstname', 'lastname', 'phone']],
            [['create', 'update'], ['firstname', 'lastname', 'phone', 'adminLists']],
            ['delete', true],
        ];
    }
    
    public function getLists()
    {
        return $this->hasMany(ListModel::class, ['id' => 'list_id'])->viaTable(ListPersonRef::tableName(), ['person_id' => 'id']);
    }
}