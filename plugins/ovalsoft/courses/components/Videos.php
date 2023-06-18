<?php namespace Ovalsoft\Courses\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Courses\Models\Video;

class Videos extends ComponentBase
{
    /** @var Video[] */
    public $video;

    /** @var string */
    public $title;

    /** @var string */
    public $youtube_video_id;

    /** @var bool */
    public $hasError = false;

    public function componentDetails()
    {
        return [
            'name'        => 'Video',
            'description' => 'Place a single video on a page'
        ];
    }

    public function defineProperties()
    {
        return [
            'video' => [
                'title' => 'Video',
                'description' => 'Video to display',
                'type' => 'dropdown',
                'required' => true
            ],
            'displayTitle' => [
                'title' => 'Display title',
                'description' => 'Display the video title',
                'type' => 'checkbox',
                'default' => false
            ],
            'titlePosition' => [
                'title' => 'Sort direction',
                'description' => 'Display video title at Top or Bottom of video',
                'type' => 'dropdown',
                'default' => 'top',
                'options' => [
                    'top' => 'Top',
                    'bottom' => 'Bottom'
                ]
            ],
            'videoIframeWidth' => [
                'title' => 'Video Display Width',
                'description' => 'Display video title at Top or Bottom of video',
                'default' => '560',
                'placeholder' => '% or pixels'
            ],
            'videoIframeHeight' => [
                'title' => 'Video Display Height',
                'description' => 'Display video title at Top or Bottom of video',
                'default' => '315',
                'placeholder' => '% or pixels'
            ],
        ];
    }

    public function getVideoOptions()
    {
        return Video::pluck('title', 'id')->toArray();
    }

    public function onRun() {
        $this->addCss('/plugins/ovalsoft/courses/assets/css/video.css');

        $this->page['displayTitle']      = $this->property('displayTitle');
        $this->page['titlePosition']     = $this->property('titlePosition');
        $this->page['videoIframeWidth']  = $this->property('videoIframeWidth');
        $this->page['videoIframeHeight'] = $this->property('videoIframeHeight');

        $video = Video::find($this->property('video'));
        if ($video) {
            $this->title = $video->title;
            $this->youtube_video_id = $video->youtube_video_id;
            return;
        }

        $this->hasError = true;
    }
}
