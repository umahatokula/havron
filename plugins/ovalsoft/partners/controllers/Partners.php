<?php namespace Ovalsoft\Partners\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Partners Back-end Controller
 */
class Partners extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $requiredPermissions = [
        'ovalsoft.partners.partners',
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

        BackendMenu::setContext('Ovalsoft.Partners', 'partners', 'partners');
    }
}
