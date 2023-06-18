<?php namespace Ovalsoft\Courses\Models;

use Model;

/**
 * Video Model
 */
class Video extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ovalsoft_courses_videos';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['title', 'youtube_video_id', 'is_published'];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'title' => 'required',
        'youtube_video_id' => 'required',
        'is_published' => 'boolean'
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [
        'is_published' => 'boolean'
    ];

    public $attributeNames = [
        'title' => 'ovalsoft.courses::lang.plugin.models.video.attributes.title',
        'youtube_video_id' => 'ovalsoft.courses::lang.plugin.models.video.attributes.yt_watch'
    ];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Extract YouTube video id if a full YouTube url was given
     *
     * @param $value
     */
    public function setYoutubeVideoIdAttribute($url)
    {
        parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
        $id = isset($my_array_of_vars['v']) ? $my_array_of_vars['v'] : $url; 

        $this->attributes['youtube_video_id'] = (isset($id)) ? $id : $url;
    }

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $hasManyThrough = [
        'groups' => [
            'RainLab\User\Models\UserGroup',
            'through' => 'Ovalsoft\Courses\Models\Playlist'
        ],
    ];
    public $belongsTo = [];
    public $belongsToMany = [
        'courses' => [
            'Ovalsoft\Courses\Models\Course',
            'table' => 'ovalsoft_courses_course_video',
            'key'      => 'video_id',
            'otherKey' => 'course_id'
        ],
        'playlists' => [
            'Ovalsoft\Courses\Models\Playlist',
            'table' => 'ovalsoft_courses_playlist_video',
            'key'      => 'video_id',
            'otherKey' => 'playlist_id'
        ],
        'categories' => [
            'Ovalsoft\Courses\Models\Category',
            'table' => 'ovalsoft_courses_category_video',
            'key'      => 'video_id',
            'otherKey' => 'category_id'
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getSourceOptions() {
        return [
            'youtube' => 'Youtube',
            'vimeo' => 'vimeo',
            'code' => 'code',
        ];
    }
}
