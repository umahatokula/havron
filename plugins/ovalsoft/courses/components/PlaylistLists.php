<?php namespace Ovalsoft\Courses\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Courses\Models\Playlist;
use RainLab\User\Models\UserGroup;

class PlaylistLists extends ComponentBase
{
    public $hasError = false;


    public function componentDetails()
    {
        return [
            'name'        => 'Playlists',
            'description' => 'Displays a list of playlists'
        ];
    }

    public function defineProperties()
    {
        return [
            // 'group' => [
            //      'title'             => 'Group',
            //      'description'       => 'Select user group',
            //      'type'              => 'dropdown',
            //      'placeholder'       => 'Select user group',
            // ],
            'perPage' => [
                 'title'             => 'Per Page',
                 'description'       => 'Number per page (used for pagination)',
                 'default'           => 15,
                 'type'              => 'string',
                 'required'          => 'true',
            ],
            'playlistPage' => [
                 'title'             => 'Playlist Page',
                 'description'       => 'Playlist details page',
                 'default'           => 'playlist',
                 'type'              => 'string',
                 'required'          => 'true',
            ],
        ];
    }


    public function onRun() {
        $this->page['playlistPage'] = $this->property('playlistPage', 'playlist');

        $groups = \Auth::getUser()->groups;
        // $code = $this->property('group') ? $this->property('group') : $groups[0]->code;
        $code = $groups[0]->code;

        $this->page['playlists'] = UserGroup::where('code', $code)->first()->playlists;

    }


    public function getGroupOptions() {
        return UserGroup::pluck('name', 'code')->toArray();
    }
}
