<?php namespace Ovalsoft\Partners\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Partners\Models\Program;
use Ovalsoft\Partners\Models\Partner;
use Ovalsoft\Partners\Models\ProgramRegistrationUpload;
use Input;
use Flash;

use Ovalsoft\Partners\Models\ProgramRegistration as ProgramRegistrationModel;

class ProgramRegistration extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Program Registration Component',
            'description' => 'Program Registration for all partners'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        $this->page['partners'] = Partner::all();

        $this->page['partner'] = Partner::where('slug', $this->property('program_slug'))->first();

        if($this->page['partner'])
            $this->page['programs'] = Program::where('partner_id', $this->page['partner']->id)->get();
    }

    public function onSelectPartner() {
        $partnerId = input('partner_id');
        $programs = Program::where('partner_id', $partnerId)->get();

        return [
            '#program_selections' => $this->renderPartial('@programs', [
            'programs' => $programs
            ])
        ];
    }

    public function onSubmitProgramRegistrationModelForm() {
        // dd(Input::file());

        $rules = [
            'partner_id'           => 'required',
            // 'program_id'           => 'required',
            'email'                => 'required',
            'fname'                => 'required',
            'lname'                => 'required',
            'phone'                => 'required',
            'gender'               => 'required',
            'dob'                  => 'required',
            'degree'               => 'required',
            'nationality'          => 'required',
            'awarding_institution' => 'required',
            'class_of_degree'      => 'required',
            'start_date'           => 'required',
            // 'declaration'          => 'required',
        ];

        $messages = [
            'partner_id.required' => 'Please select a partner',
            'program_id.required' => 'Please select a program',
            'fname.required' => 'Please enter your First name',
            'lname.required' => 'Please enter your Last name',
            'start_date.required' => 'Please select a start date',
            'dob.required' => 'Date of birth is required',
            'phone.required' => 'Phone number is required',
            'degree.required' => 'Class of degree is required',
        ];

        $validator = \Validator::make(post(), $rules, $messages);

        if ($validator->fails()) {
            throw new \ValidationException($validator);
        }

        $reg = new ProgramRegistrationModel;
        $reg->partner_id           = post('partner_id');
        $reg->program_id           = post('program_id');
        $reg->email                = post('email');
        $reg->fname                = post('fname');
        $reg->lname                = post('lname');
        $reg->phone                = post('phone');
        $reg->gender               = post('gender');
        $reg->dob                  = post('dob');
        $reg->nationality          = post('nationality');
        $reg->country_of_residence = post('country_of_residence');
        $reg->program_selections   = post('program_selections');
        $reg->degree               = post('degree');
        $reg->awarding_institution = post('awarding_institution');
        $reg->class_of_degree      = post('class_of_degree');
        $reg->start_date           = post('start_date');
        $reg->declaration          = 1;
        $reg->save();

        if (Input::hasFile('academic_transcript')) {

            $file = new \System\Models\File;
            $file->data = Input::file('academic_transcript');
            $file->is_public = true;
            $file->save();

            $reg->academic_transcript_attachment()->add($file);
            
        }

        if (Input::hasFile('cv')) {

            $file = new \System\Models\File;
            $file->data = Input::file('cv');
            $file->is_public = true;
            $file->save();

            $reg->cv_attachment()->add($file);
        }

        if (Input::hasFile('professional_or_academic_reference')) {

            $file = new \System\Models\File;
            $file->data = Input::file('professional_or_academic_reference');
            $file->is_public = true;
            $file->save();

            $reg->professional_or_academic_reference_attachment()->add($file);
        }

        if (Input::hasFile('mode_of_identification')) {

            $file = new \System\Models\File;
            $file->data = Input::file('mode_of_identification');
            $file->is_public = true;
            $file->save();

            $reg->mode_of_identification_attachment()->add($file);
        }



        // if (Input::hasFile('academic_transcript')) {

        //     $path = Input::file('academic_transcript')->store(
        //         'registration_uploads',
        //         'dropbox'
        //     );
        //     $path = Input::file('academic_transcript')->store('registration_uploads', 'public');
        //     $upload = new ProgramRegistrationUpload;
        //     $upload->program_registration_id = $reg->id;
        //     $upload->mime                    = Input::file('academic_transcript')->getMimeType();
        //     $upload->upload_type             = 'academic_transcript';
        //     $upload->original_name           = Input::file('academic_transcript')->getClientOriginalName();
        //     $upload->extension               = Input::file('academic_transcript')->getClientOriginalExtension();
        //     $upload->size                    = Input::file('academic_transcript')->getSize();
        //     $upload->path                    = $path;
        //     $upload->save();
        // }

        // if (Input::hasFile('cv')) {

        //     $path = Input::file('cv')->store(
        //         'registration_uploads',
        //         'dropbox'
        //     );
        //     $path = Input::file('cv')->store('registration_uploads', 'public');
        //     $upload = new ProgramRegistrationUpload;
        //     $upload->program_registration_id = $reg->id;
        //     $upload->mime                    = Input::file('cv')->getMimeType();
        //     $upload->upload_type             = 'cv';
        //     $upload->original_name           = Input::file('cv')->getClientOriginalName();
        //     $upload->extension               = Input::file('cv')->getClientOriginalExtension();
        //     $upload->size                    = Input::file('cv')->getSize();
        //     $upload->mime                    = Input::file('cv')->getMimeType();
        //     $upload->path                    = $path;
        //     $upload->save();
        // }

        // if (Input::hasFile('professional_or_academic_reference')) {

        //     $path = Input::file('professional_or_academic_reference')->store(
        //         'registration_uploads',
        //         'dropbox'
        //     );
        //     $path = Input::file('professional_or_academic_reference')->store('registration_uploads', 'public');
        //     $upload = new ProgramRegistrationUpload;
        //     $upload->program_registration_id = $reg->id;
        //     $upload->mime                    = Input::file('professional_or_academic_reference')->getMimeType();
        //     $upload->upload_type             = 'professional_or_academic_reference';
        //     $upload->original_name           = Input::file('professional_or_academic_reference')->getClientOriginalName();
        //     $upload->extension               = Input::file('professional_or_academic_reference')->getClientOriginalExtension();
        //     $upload->size                    = Input::file('professional_or_academic_reference')->getSize();
        //     $upload->mime                    = Input::file('professional_or_academic_reference')->getMimeType();
        //     $upload->path                    = $path;
        //     $upload->save();
        // }

        // if (Input::hasFile('mode_of_identification')) {

        //     $path = Input::file('mode_of_identification')->store(
        //         'registration_uploads',
        //         'dropbox'
        //     );
        //     $path = Input::file('mode_of_identification')->store('registration_uploads', 'public');
        //     $upload = new ProgramRegistrationUpload;
        //     $upload->program_registration_id = $reg->id;
        //     $upload->mime                    = Input::file('mode_of_identification')->getMimeType();
        //     $upload->upload_type             = 'mode_of_identification';
        //     $upload->original_name           = Input::file('mode_of_identification')->getClientOriginalName();
        //     $upload->extension               = Input::file('mode_of_identification')->getClientOriginalExtension();
        //     $upload->size                    = Input::file('mode_of_identification')->getSize();
        //     $upload->mime                    = Input::file('mode_of_identification')->getMimeType();
        //     $upload->path                    = $path;
        //     $upload->save();
        // }

        Flash::success('Registration Successfully!');
        return redirect()->back();

    }
}
