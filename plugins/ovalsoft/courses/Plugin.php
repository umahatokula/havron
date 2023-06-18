<?php namespace Ovalsoft\Courses;

use Backend;
use System\Classes\PluginBase;
use RainLab\User\Models\UserGroup;
use Pixel\Shop\Models\Item as ShopItem;
use Event;

/**
 * Courses Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = ['Rainlab.User', 'Pixel.Shop'];
    
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Courses',
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
        
        UserGroup::extend(function($model) {
            $model->belongsToMany['playlists'] = [
                'Ovalsoft\Courses\Models\Playlist', 
                'table' => 'ovalsoft_courses_group_playlist',
                'key'      => 'group_id',
                'otherKey' => 'playlist_id',
            ];

            $model->belongsToMany['courses'] = [
                'Ovalsoft\Courses\Models\Course', 
                'table' => 'ovalsoft_courses_course_group',
                'key'      => 'group_id',
                'otherKey' => 'course_id',
            ];
        });
        
        ShopItem::extend(function($model) {
            $model->hasOne['course'] = [
                'Ovalsoft\Courses\Models\Course', 
                'table' => 'ovalsoft_courses_courses',
                'key'      => 'slug',
                'otherKey' => 'slug',
            ];
        });

        \Event::listen('offline.sitesearch.query', function ($query) {

            // The controller is used to generate page URLs.
            $controller = \Cms\Classes\Controller::getController() ?? new \Cms\Classes\Controller();

            // Search your plugin's contents
            $items = ShopItem
                ::where('name', 'like', "%${query}%")
                // ->orWhere('content', 'like', "%${query}%")
                ->get();

            // Now build a results array
            $results = $items->map(function ($item) use ($query, $controller) {

                // If the query is found in the title, set a relevance of 2
                $relevance = mb_stripos($item->name, $query) !== false ? 2 : 1;

                return [
                    'title'     => $item->name,
                    'text'      => $item->description,
                    'url'       => $controller->pageUrl('products', ['slug' => $item->slug]),
                    // 'thumb'     => optional($item->images)->first(), // Instance of System\Models\File
                    'relevance' => $relevance, // higher relevance results in a higher
                                            // position in the results listing
                    // 'meta' => 'data',       // optional, any other information you want
                                            // to associate with this result
                    // 'model' => $item,       // optional, pass along the original model
                ];
            });

            return [
                'provider' => 'Document', // The badge to display for this result
                'results'  => $results,
            ];
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
            'Ovalsoft\Courses\Components\Videos'         => 'videos',
            'Ovalsoft\Courses\Components\PlaylistLists'  => 'playlistLists',
            'Ovalsoft\Courses\Components\PlaylistVideos' => 'playlistVideos',
            'Ovalsoft\Courses\Components\Course'         => 'course',
            'Ovalsoft\Courses\Components\CourseDetails'  => 'courseDetails',
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
            'ovalsoft.courses.courses' => [
                'tab' => 'Courses',
                'label' => 'Manage courses',
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
            'courses' => [
                'label'       => 'Havron Courses',
                'url'         => Backend::url('ovalsoft/courses/courses'),
                'icon'        => 'icon-graduation-cap',
                'permissions' => ['ovalsoft.courses.*'],
                'order'       => 500,
                'sideMenu'    => [
                    'courses' => [
                        'label'       => 'Courses',
                        'url'         => Backend::url('ovalsoft/courses/courses'),
                        'icon'        => 'icon-graduation-cap',
                        'permissions' => ['ovalsoft.courses.*'],
                        'order'       => 500,
                    ],  
                    'videos' => [
                        'label'       => 'Videos',
                        'url'         => Backend::url('ovalsoft/courses/videos'),
                        'icon'        => 'icon-film',
                        'permissions' => ['ovalsoft.courses.*'],
                        'order'       => 500,
                    ],  
                    'playlists' => [
                        'label'       => 'Playlists',
                        'url'         => Backend::url('ovalsoft/courses/playlists'),
                        'icon'        => 'icon-bars',
                        'permissions' => ['ovalsoft.courses.*'],
                        'order'       => 500,
                    ],  
                    'audios' => [
                        'label'       => 'Audios',
                        'url'         => Backend::url('ovalsoft/courses/audios'),
                        'icon'        => 'icon-bullhorn',
                        'permissions' => ['ovalsoft.courses.*'],
                        'order'       => 500,
                    ],
                    'documents' => [
                        'label'       => 'Documents',
                        'url'         => Backend::url('ovalsoft/courses/documents'),
                        'icon'        => 'icon-file-pdf-o',
                        'permissions' => ['ovalsoft.courses.*'],
                        'order'       => 500,
                    ],
                    'categories' => [
                        'label'       => 'Categories',
                        'url'         => Backend::url('ovalsoft/courses/categories'),
                        'icon'        => 'icon-bars',
                        'permissions' => ['ovalsoft.courses.*'],
                        'order'       => 500,
                    ],            
                ]
            ],
        ];
    }

}
