<?php namespace Ovalsoft\Courses\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Documents Back-end Controller
 */
class Documents extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ovalsoft.Courses', 'courses', 'sideMenu');
    }
}
