<?php namespace Ovalsoft\Courses\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Courses\Models\Playlist;

class PlaylistVideos extends ComponentBase
{
    public $hasError = false;

    public function componentDetails()
    {
        return [
            'name'        => 'Single Playlist',
            'description' => 'Dsiplays videos in  a playlist'
        ];
    }

    public function defineProperties()
    {
        return [
            // 'userGroup '
        ];
    }

    public function onRun() {

        $this->addJs('/plugins/ovalsoft/courses/assets/html5lightbox/jquery.js');
        $this->addJs('/plugins/ovalsoft/courses/assets/html5lightbox/html5lightbox.js');

        $this->page['playlist'] = Playlist::with('videos')->where('slug', $this->param('playlist'))->first();
        // dd($this->page['playlist']);
    }
}
