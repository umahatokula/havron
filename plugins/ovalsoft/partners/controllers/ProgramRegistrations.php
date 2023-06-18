<?php namespace Ovalsoft\Partners\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

use Ovalsoft\Partners\Models\ProgramRegistration;
use Ovalsoft\Partners\Models\Partner as PartnerModel;

use Illuminate\Support\Facades\Storage;

/**
 * Program Registrations Back-end Controller
 */
class ProgramRegistrations extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        // 'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.ImportExportController',  
    ];

    public $requiredPermissions = [
        'ovalsoft.partners.create_new_registration',
        'ovalsoft.partners.view_registrations',
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    public $importExportConfig = 'config_import_export.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ovalsoft.Partners', 'partners', 'programregistrations');
    }
    
    public function index()
    {
        $user = \BackendAuth::getUser();
        $login = $user->login;

        $partner = PartnerModel::where('name', 'LIKE', '%'.$login.'%')->first();
        if($partner) {
            $this->vars['registrations'] = ProgramRegistration::find($partner->id);
        }

        // Call the ListController behavior index() method
        $this->asExtension('ListController')->index();
    }

    public function onViewRegistration() {

        $this->vars['registration'] = ProgramRegistration::find(post('partner_id'));

        return $this->makePartial('view_registration');
    }

    function onDownloadHandler()
    {
        $pathToFile = storage_path('app/registration_uploads/'.post('pathtofile'));
        $fileName = 'download.pdf';
        $headers = [
            'Content-Type' => 'application/pdf'
        ];
        return Storage::download($pathToFile);
        
    }
}
