<?php

namespace luya\smsnewsletter\admin;

/**
 * Szeneaarau Admin Module.
 *
 * File has been created with `module/create` command. 
 * 
 * @author
 * @since 1.0.0
 */
class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-smsnewsletter-person' => 'luya\smsnewsletter\admin\apis\PersonController',
        'api-smsnewsletter-list' => 'luya\smsnewsletter\admin\apis\ListController',
        'api-smsnewsletter-listpersonref' => 'luya\smsnewsletter\admin\apis\ListPersonRefController',
        'api-smsnewsletter-logmessage' => 'luya\smsnewsletter\admin\apis\LogMessageController',
        'api-smsnewsletter-logmessageperson' => 'luya\smsnewsletter\admin\apis\LogMessagePersonController',
        
    ];
    
    /**
     * @var string the parse the region if not international number is provided. Example:
     * 
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
    
    public $aspsmsKey;
    
    public $aspsmsPassword;
    
    public function getMenu()
    {
        return (new \luya\admin\components\AdminMenuBuilder($this))
        ->node('Person', 'sms')
            ->group('Group')
                ->itemApi('Persons', 'smsnewsletteradmin/person/index', 'label', 'api-smsnewsletter-person')
                ->itemApi('Lists', 'smsnewsletteradmin/list/index', 'label', 'api-smsnewsletter-list')
                //->itemApi('List Person Ref', 'smsnewsletteradmin/list-person-ref/index', 'label', 'api-smsnewsletter-listpersonref')
            ->group('Log')
                ->itemApi('Message', 'smsnewsletteradmin/log-message/index', 'label', 'api-smsnewsletter-logmessage')
                ->itemApi('Person', 'smsnewsletteradmin/log-message-person/index', 'label', 'api-smsnewsletter-logmessageperson');
        
    }
}