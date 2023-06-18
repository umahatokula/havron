<?php namespace Ovalsoft\MajicFormsMailer\Models;

use Model;
use DB;
use System\Models\MailTemplate;
use Martin\Forms\Models\Record as MajicFormRecord;

/**
 * Mailer Model
 */
class Mailer extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ovalsoft_majicformsmailer_mailers';

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
        'group'         => 'required',
        'subject'       => 'required',
        'use_template'  => 'required',
        // 'message'       => 'required',
        // 'mail_template' => 'required',
        'processed'     => 'required',
    ];

    public function getGroupOptions() {
        return MajicFormRecord::distinct()->pluck('group', 'group');
    }


    public function getMailTemplateOptions() {
        return MailTemplate::listAllTemplates();
    }
}
