<?php namespace Ovalsoft\Partners\Models;

use Backend\Models\ExportModel;
use Ovalsoft\Partners\Models\ProgramRegistration;

/**
 * ProgramRegistrationExport Model
 */
class ProgramRegistrationExport extends ExportModel
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

    protected $rules = [];

    public function exportData($columns, $sessionKey = null)
    {
        $registrations = ProgramRegistration::all();
        $registrations->each(function($registration) use ($columns) {
            $registration->addVisible($columns);
        });
        return $registrations->toArray();
    }
}
