<?php namespace Ovalsoft\MajicFormsMailer;

use Backend;
use System\Classes\PluginBase;
use Event;
use Mail;
use DB;
use Ovalsoft\MajicFormsMailer\Models\Mailer;

/**
 * MajicFormsMailer Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = ['Martin.Forms'];

    
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'MajicFormsMailer',
            'description' => 'No description provided yet...',
            'author'      => 'Ovalsoft',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        Event::listen('backend.menu.extendItems', function($manager) {

            $manager->addSideMenuItems('Martin.Forms', 'forms', [
                'sideMenu' => [
                    'label' => 'Mailer',
                    'icon'         => 'icon-envelope',
                    'url'          => Backend::url('ovalsoft/majicformsmailer/mailers/index'),
                    'permissions'  => ['martin.forms.access_records'],
                    'counterLabel' => 'Un-Read Messages'
                ]
            ]);

        });

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Ovalsoft\MajicFormsMailer\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'ovalsoft.majicformsmailer.some_permission' => [
                'tab' => 'MajicFormsMailer',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'majicformsmailer' => [
                'label'       => 'MajicFormsMailer',
                'url'         => Backend::url('ovalsoft/majicformsmailer/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['ovalsoft.majicformsmailer.*'],
                'order'       => 500,
            ],
        ];
    }

    public function registerSchedule($schedule) {
        $schedule->call(function () {

            // Get all unprocessed mails
            $unprocessed = Mailer::where('processed', FALSE)->get();

            foreach ($unprocessed as $mail) {
                

            // for ($i=0; $i < 1000; $i++) { 
            //     \Log::info('Showing user profile for user: '.$i);
            // }
            
            $subject       = $mail->subject;
            $use_template  = $mail->use_template;
            $mail_template = $mail->mail_template;
            $vars          = $mail->vars;
            $group         = $mail->group;
            $msgPlain      = strip_tags($mail->message);
            $msg           = $mail->message;

            $vars = [
                'subject'       => $subject,
                'msg'           => $msg,
                'msgPlain'      => $msgPlain,
                'use_template'  => $use_template,
                'mail_template' => $mail_template,
            ];
        
            //Fetching users ids
            $forms = DB::table('martin_forms_records')->where('group', $group)->get();
            
                    
            foreach ($forms as $form) {
                        
                $formData = json_decode($form->form_data);
                $user = ['name' => $formData->name, 'email' => $formData->email];
                
                $array = [
                    'email'   => $user['email'],
                    'name'    => $user['name'],
                    'subject' => $subject,
                    'mail_template' => $mail_template
                ];
        
                if ($array['email']) {
        
                    if(filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
                        
                        //Sending mail
                        try {
        
                            if ($use_template) {
                
                                Mail::send($array['mail_template'], $array, function($message) use ($array) {
                
                                    $message->to($array['email'], $array['name']);
                                    $message->subject($array['subject']);
                
                                });
                
                            } else {
        
                                Mail::send([
                                    'text' => $vars['msgPlain'],
                                    'html' => $vars['msg'],
                                    'raw' => true
                                ], $array, function($message) use($array) {
        
                                $message->subject($array['subject']);
                                $message->to($array['email'], $array['name']);
        
                                });
                
                            }
                            
                        } catch (\Exception $e) {
                            // Do nothing
                        }
                    }
        
                }
        
            }

            // Set status as processed
            $mail->processed = TRUE;
            $mail->save();
        }
    })->everyMinute();
}
}
