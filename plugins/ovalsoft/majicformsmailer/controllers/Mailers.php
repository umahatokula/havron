<?php namespace Ovalsoft\MajicFormsMailer\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Ovalsoft\MajicFormsMailer\Models\Mailer;
use DB;
use Queue;
use Flash;
use Mail;

/**
 * Mailers Back-end Controller
 */
class Mailers extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Martin.Forms', 'forms', 'sideMenu');
    }


    /**
     * Passing to form
     * */
    public function index()
    {
        $config = $this->makeConfig('$/ovalsoft/majicformsmailer/models/mailer/fields.yaml');
        $config->model = new Mailer;
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $this->vars['widget'] = $widget;

        $this->vars['groups'] = DB::table('martin_forms_records')->select('group')->distinct()->get();
        
        $this->asExtension('FormController')->create();

    }

    /**
     * Sending Mail
     * */
    public function onSendMail()
    {

        /**
         * Getting form results
         * */
        $group         = post('group');
        $subject       = post('subject');
        $msg           = post('message');
        $test_email    = post('testEmail');
        $use_template  = post('use_template');
        $mail_template = post('mail_template');

        /**
         * Checking if there's no data
         * */
        if($subject == "" || $msg == ""):
            Flash::error('All fields are required');
            return ;
        endif;

        /**
         * Striping tags for the plain version of mail
         * */
        $msgPlain = strip_tags(post('message'));

        /**
         * Setting vars array for mail template
         * */
        $vars = [
            'subject'       => $subject,
            'msg'           => $msg,
            'msgPlain'      => $msgPlain,
            'use_template'  => $use_template,
            'mail_template' => $mail_template,
            ];

        /**
         * SEND TEST EMAIL
         * */
        if($test_email != "") {
            //email and subject array
            $array = [
            'email' => $test_email,
            'subject'=>$subject
            ];

            //Sending mail
            if(filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
                try{
                    
                    if (post('use_template')) {

                        Mail::queue(post('mail_template'), $vars, function($message) use ($array) {

                            $message->to($array['email'], 'umaha');
                            $message->subject($array['subject']);

                        });

                    } else {

                        Mail::queue([
                                    'text' => $msgPlain,
                                    'html' => $msg,
                                    'raw' => true
                                ], $vars, function($message) use ($array) {

                                $message->subject($array['subject']);
                                $message->to($array['email'], "Test Reciever");
                                
                        });

                    }

                } catch (\Exception $e) {
                    Flash::error($e);
                    return ;
                }
            } else {
              Flash::error('Please enter a valid email address.');
              return ;
            }

            /**
             * Success message
             * */
            Flash::success('Message has been sent successfully');
            return ;
        }



        /**
         * 
         * SEND MAIL TO SELECTED GROUP
         * 
         * */
        $count = DB::table('martin_forms_records')->where('group', $group)->count();

        if ($count == 0) {
            Flash::error('There are no forms in this group');
            return;
        }

        $mailer = new Mailer;
        $mailer->group = $group;
        $mailer->subject = $subject;
        $mailer->use_template = $use_template;
        $mailer->message = $msg;
        $mailer->mail_template = $mail_template;
        $mailer->processed = FALSE;
        $mailer->save();

        Flash::success($count.' message(s) sent successfully to');
        return redirect()->back();

    }






    /**
     * This function checks if there's a value in test email field.
     * if there's any value the send button to all group will be hidden
     * */
    public function onCheckTestEmail()
    {
        if(post('testEmail') == ""){

            return  ['correct'=> 0];

        } else {

            return  ['correct'=> 1];

        }
    }
}
