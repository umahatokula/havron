<?php namespace Ovalsoft\Partners\Models;

use Model;
use Ovalsoft\Partners\Models\Partner as PartnerModel;
use System\Models\File;

/**
 * ProgramRegistration Model
 */
class ProgramRegistration extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ovalsoft_partners_program_registrations';

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
        // 'academic_transcript_attachment' => 'image|mimes:jpeg,png,jpg|max:1524'
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
    public $hasMany = [
        'uploads' => ['Ovalsoft\Partners\Models\ProgramRegistrationUpload'],
    ];
    public $belongsTo = [
        'partner' => ['Ovalsoft\Partners\Models\Partner'],
        'program' => ['Ovalsoft\Partners\Models\Program'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'academic_transcript_attachment'                => File::class,
        'cv_attachment'                                 => File::class,
        'professional_or_academic_reference_attachment' => File::class,
        'mode_of_identification_attachment'             => File::class,
    ];
    public $attachMany = [];

    function getPartnerOptions() {
        $user = \BackendAuth::getUser();
        $login = $user->login;

        return PartnerModel::where('name', 'LIKE', '%'.$login.'%')->lists('name', 'id');
    }
}
