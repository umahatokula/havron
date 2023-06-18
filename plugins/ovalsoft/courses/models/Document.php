<?php namespace Ovalsoft\Courses\Models;

use Model;

/**
 * Document Model
 */
class Document extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ovalsoft_courses_documents';

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
        'title' =>'required',
        'slug' => 'required',
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
    public $belongsTo = [];
    public $belongsToMany = [
        'courses' => [
            'Ovalsoft\Courses\Models\Course',
            'table' => 'ovalsoft_courses_course_document',
            'key'      => 'document_id',
            'otherKey' => 'course_id'
        ],
        'categories' => [
            'Ovalsoft\Courses\Models\Category',
            'table' => 'ovalsoft_courses_cat_doc',
            'key'      => 'document_id',
            'otherKey' => 'category_id'
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'file_path' => 'System\Models\File'
    ];
    public $attachMany = [];
}
