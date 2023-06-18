<?php namespace RedMarlin\Leafletmap;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'redmarlin.leafletmap::lang.plugin.name',
            'description' => 'redmarlin.leafletmap::lang.plugin.description',
            'author'      => 'RedMarlin',
            'icon'        => 'icon-globe'
        ];
    }

    public function registerComponents(){
    return [
            'RedMarlin\LeafletMap\Components\LeafletMap' => 'LeafletMap',
    ];
    }

    public function registerSettings()
    {
    }
}
