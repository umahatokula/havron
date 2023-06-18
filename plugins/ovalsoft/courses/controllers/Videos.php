<?php namespace Ovalsoft\Courses\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Ovalsoft\Courses\Models\Video;

/**
 * Videos Back-end Controller
 */
class Videos extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ovalsoft.Courses', 'courses', 'videos');
    }

    public function create() {

        $config = $this->makeConfig('$/ovalsoft/courses/models/video/fields.yaml');
        $config->model = new Video;
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $this->vars['widget'] = $widget;

        $this->asExtension('FormController')->create();
    }
}
