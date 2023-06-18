<?php namespace Ovalsoft\Lecturers\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Lecturers\Models\Lecturer as LecturerModel;

class Lecturer extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Lecturer Component',
            'description' => 'Show Lecturer details'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        $this->page['lecturer'] = LecturerModel::where('slug', $this->property('slug'))->active()->first();
    }
}
