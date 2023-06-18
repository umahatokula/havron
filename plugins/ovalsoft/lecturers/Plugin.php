<?php namespace Ovalsoft\Lecturers;

use Backend;
use System\Classes\PluginBase;

/**
 * Lecturers Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Lecturers',
            'description' => 'No description provided yet...',
            'author'      => 'Ovalsoft',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Ovalsoft\Lecturers\Components\Lecturers' => 'lecturersComponent',
            'Ovalsoft\Lecturers\Components\Lecturer' => 'lecturerComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'ovalsoft.lecturers.lecturers' => [
                'tab' => 'Lecturers',
                'label' => 'Some permission',
                'roles' => ['developer']
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'lecturers' => [
                'label'       => 'Facilitators',
                'url'         => Backend::url('ovalsoft/lecturers/lecturers'),
                'icon'        => 'icon-leaf',
                'permissions' => ['ovalsoft.lecturers.*'],
                'order'       => 500,
            ],
        ];
    }
}
