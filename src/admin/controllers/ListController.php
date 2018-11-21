<?php

namespace luya\smsnewsletter\admin\controllers;

/**
 * List Controller.
 *
 * File has been created with `crud/create` command.
 */
class ListController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'luya\smsnewsletter\models\ListModel';
}
