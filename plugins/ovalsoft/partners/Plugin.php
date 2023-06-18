<?php namespace Ovalsoft\Partners;

use Backend;
use System\Classes\PluginBase;
use Event;
use Ovalsoft\Partners\Models\Partner;

/**
 * partners Plugin Information File
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
            'name'        => 'partners',
            'description' => 'No description provided yet...',
            'author'      => 'ovalsoft',
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
        
        Event::listen('pages.menuitem.listTypes', function() {
            return [
                'partners-page'=>'Partners Page',
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function($type) {
            if ($type == 'partners-page')
                return Partner::getMenuTypeInfo($type);
        });

        Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme) {
            if ($type == 'partners-page')
                return Partner::resolveMenuItem($item, $url, $theme);
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Ovalsoft\Partners\Components\ProgramRegistration' => 'programRegistrationComponent',
            'Ovalsoft\Partners\Components\Programs' => 'programsComponent',
            'Ovalsoft\Partners\Components\PartnerDetails' => 'partnersDetails',
            'Ovalsoft\Partners\Components\Partner' => 'partners',
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
            'ovalsoft.partners.partners' => [
                'tab' => 'Partners',
                'label' => 'Create, View, Edit and Delete Partners',
                'roles' => ['developer']
            ],
            'ovalsoft.partners.programs' => [
                'tab' => 'Partners',
                'label' => 'Create, View, Edit and Delete Programs',
                'roles' => ['developer']
            ],
            'ovalsoft.partners.create_new_registration' => [
                'tab' => 'Partners',
                'label' => 'Create New Registration',
                'roles' => ['developer']
            ],
            'ovalsoft.partners.view_registrations' => [
                'tab' => 'Partners',
                'label' => 'View Registrations',
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
            'partners' => [
                'label'       => 'Partners',
                'url'         => Backend::url('ovalsoft/partners/partners'),
                'icon'        => 'icon-mars-double',
                'permissions' => ['ovalsoft.partners.partners', 'ovalsoft.partners.programs'],
                'order'       => 500,
                'sideMenu'    => [
                    'partners' => [
                        'label'       => 'Partners',
                        'url'         => Backend::url('ovalsoft/partners/partners'),
                        'icon'        => 'icon-mars-double',
                        'permissions' => ['ovalsoft.partners.partners'],
                        'order'       => 500,
                    ],
                    'programs' => [
                        'label'       => 'Programs',
                        'url'         => Backend::url('ovalsoft/partners/programs'),
                        'icon'        => 'icon-circle-thin',
                        'permissions' => ['ovalsoft.partners.programs'],
                        'order'       => 500,
                    ],        
                ] ,
            ],
            'program_registrations' => [
                'label'       => 'Program Registrations',
                'url'         => Backend::url('ovalsoft/partners/programregistrations'),
                'icon'        => 'icon-circle-thin',
                'permissions' => ['ovalsoft.partners.create_new_registration', 'ovalsoft.partners.view_registrations',],
                'order'       => 500,
            ], 
        ];
    }
}
