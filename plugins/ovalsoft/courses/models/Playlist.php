<?php namespace Ovalsoft\Courses\Models;

use Model;
use RainLab\User\Models\UserGroup;

/**
 * Playlist Model
 */
class Playlist extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ovalsoft_courses_playlists';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

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
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'videos' => [
            'Ovalsoft\Courses\Models\Video',
            'table' => 'ovalsoft_courses_playlist_video',
            'key'      => 'playlist_id',
            'otherKey' => 'video_id'
        ],
        'groups' => [
            'RainLab\User\Models\UserGroup',
            'table' => 'ovalsoft_courses_group_playlist',
            'key'      => 'playlist_id',
            'otherKey' => 'group_id'
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
}
