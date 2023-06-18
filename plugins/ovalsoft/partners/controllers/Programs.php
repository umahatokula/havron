<?php namespace Ovalsoft\Partners\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Programs Back-end Controller
 */
class Programs extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $requiredPermissions = [
        'ovalsoft.partners.programs',
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ovalsoft.Partners', 'partners', 'programs');
    }
}
