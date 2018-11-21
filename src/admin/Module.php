<?php

namespace luya\smsnewsletter\admin;

use yii\base\InvalidConfigException;

/**
 * SMS Newsletter admin module.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Module extends \luya\admin\base\Module
{
    /**
     * @inheritdoc
     */
    public $apis = [
        'api-smsnewsletter-person' => 'luya\smsnewsletter\admin\apis\PersonController',
        'api-smsnewsletter-list' => 'luya\smsnewsletter\admin\apis\ListController',
        'api-smsnewsletter-listpersonref' => 'luya\smsnewsletter\admin\apis\ListPersonRefController',
        'api-smsnewsletter-logmessage' => 'luya\smsnewsletter\admin\apis\LogMessageController',
        'api-smsnewsletter-logmessageperson' => 'luya\smsnewsletter\admin\apis\LogMessagePersonController',
    ];
    
    /**
     * @var string the parse the region if not international number is provided. Example:
     * + DE
     * + CH
     * + EN
     * + GB
     * + FR
     * + ...
     *
     * @see https://github.com/giggsey/libphonenumber-for-php
     */
    public $defaultNumberRegion;
    
    /**
     * @var string The default value which should be used for the origin name (sender).
     */
    public $originName;
    
    /**
     * @var string The key for the aspsms API.
     */
    public $aspsmsKey;
    
    /**
     * @var string The password for the aspsms API.
     */
    public $aspsmsPassword;
    
    /**
     *
     * {@inheritDoc}
     * @see \luya\base\Module::init()
     */
    public function init()
    {
        parent::init();
        
        if (!$this->aspsmsKey || !$this->aspsmsPassword) {
            throw new InvalidConfigException("The aspsmsKey and aspsmsPassword must be configured.");
        }
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \luya\admin\base\Module::getMenu()
     */
    public function getMenu()
    {
        return (new \luya\admin\components\AdminMenuBuilder($this))
        ->node('sms.node.title', 'message')
            ->group('sms.group.manage')
                ->itemApi('sms.group.manage.persons', 'smsnewsletteradmin/person/index', 'person', 'api-smsnewsletter-person')
                ->itemApi('sms.group.manage.lists', 'smsnewsletteradmin/list/index', 'list', 'api-smsnewsletter-list')
            ->group('sms.group.log')
                ->itemApi('sms.group.log.message', 'smsnewsletteradmin/log-message/index', 'info', 'api-smsnewsletter-logmessage')
                ->itemApi('sms.group.log.persons', 'smsnewsletteradmin/log-message-person/index', 'info', 'api-smsnewsletter-logmessageperson');
    }
    
    /**
     *
     */
    public static function onLoad()
    {
        self::registerTranslation('smsnewsletteradmin', static::staticBasePath() . '/messages', [
            'smsnewsletteradmin' => 'smsnewsletteradmin.php',
        ]);
    }
    
    /**
     *
     * @param string $message
     * @param array $params
     * @return string
     */
    public static function t($message, array $params = [])
    {
        return parent::baseT('smsnewsletteradmin', $message, $params);
    }
}
