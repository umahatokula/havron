<?php namespace Ovalsoft\Lecturers\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Lecturers\Models\Lecturer as LecturerModel;

class Lecturers extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Lecturers Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        $this->page['lecturers'] = LecturerModel::active()->get();
    }
}
