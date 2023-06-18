<?php namespace Ovalsoft\Courses\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Courses\Models\Course as CourseModel;

class CourseDetails extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'CourseDetails Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                 'title'             => 'Course Slug',
                 'description'       => 'Course Slug',
                 'type'              => 'string',
                 'required'          => 'true',
            ],
        ];
    }

    public function onRun() {

        $slug = $this->property('slug');

        $course = CourseModel::where('slug', $slug)->first();
        $this->page['course'] = $course;
        
    }
}
