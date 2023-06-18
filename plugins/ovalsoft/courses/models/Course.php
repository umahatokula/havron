<?php namespace Ovalsoft\Courses\Models;

use Model;
use Str;
use Responsiv\Currency\Models\Currency as CurrencyModel;
use Pixel\Shop\Models\Item;

/**
 * Course Model
 */
class Course extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ovalsoft_courses_courses';

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
    public $rules = [
        'name' => 'required',
        'slug' => 'required',
        'code' => 'required',
        // 'groups' => 'required',
        // 'course_image' => 'required',
    ];

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
    public $belongsTo = [
        'item' => [
            'Pixel\Shop\Models\Item',
            'table' => 'ovalsoft_courses_course_video',
            'key'      => 'product_id',
            'otherKey' => 'id'
        ],
    ];
    public $belongsToMany = [
        'videos' => [
            'Ovalsoft\Courses\Models\Video',
            'table' => 'ovalsoft_courses_course_video',
            'key'      => 'course_id',
            'otherKey' => 'video_id'
        ],
        'playlists' => [
            'Ovalsoft\Courses\Models\Playlist',
            'table' => 'ovalsoft_courses_course_playlist',
            'key'      => 'course_id',
            'otherKey' => 'playlist_id'
        ],
        'groups' => [
            'RainLab\User\Models\UserGroup',
            'table' => 'ovalsoft_courses_course_group',
            'key'      => 'course_id',
            'otherKey' => 'group_id',
        ],
        'audios' => [
            'Ovalsoft\Courses\Models\Audio',
            'table' => 'ovalsoft_courses_audio_course',
            'key'      => 'course_id',
            'otherKey' => 'audio_id'
        ],
        'documents' => [
            'Ovalsoft\Courses\Models\Document',
            'table' => 'ovalsoft_courses_course_document',
            'key'      => 'course_id',
            'otherKey' => 'document_id'
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'course_image' => 'System\Models\File'
    ];
    public $attachMany = [];

    public function getPlaylistIdOptions() {
        return Playlist::pluck('name', 'id');
    }
	
	public function getCurrencyOptions(){
		return CurrencyModel::isEnabled()->lists('currency_code','currency_code');
	}

    /**
     * create product on save of this model
     */
    public function afterSave() {
        $item = Item::where('slug', $this->slug)->first();

        if(!$item) {
            $item = new Item;
        }

        $item->name              = $this->name;
        $item->slug              = $this->slug;
        $item->code              = $this->code;
        $item->type              = 'product';
        $item->currency          = $this->currency;
        $item->price             = $this->price;
        $item->old_price         = $this->old_price;
        $item->description       = $this->description;
        $item->save();
    }

    /**
     * Update product on update of this model
     */
    public function afterUpdate() {
        $item = Item::where('slug', $this->slug)->first();

        if(!$item) {
            $item = new Item;
        }

        $item->name              = $this->name;
        $item->slug              = $this->slug;
        $item->code              = $this->code;
        $item->type              = 'product';
        $item->currency          = $this->currency;
        $item->price             = $this->price;
        $item->old_price         = $this->old_price;
        $item->description       = $this->description;
        $item->is_visible        = $this->is_published;
        $item->save();
    }

    /**
     * Delete product on deletion of this model
     */
    public function afterDelete() {
        $item = Item::where('slug', $this->slug)->delete();
    }
}
