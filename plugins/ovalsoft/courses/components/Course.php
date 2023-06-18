<?php namespace Ovalsoft\Courses\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Courses\Models\Course as CourseModel;
use RainLab\User\Models\UserGroup;

use Cms\Classes\Page;

class Course extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Course',
            'description' => 'Display a course content inclusive of videos playlists, audios and documents'
        ];
    }

    public function defineProperties()
    {
        return [
            // 'group' => [
            //      'title'       => 'Group',
            //      'description' => 'Select user group',
            //      'type'        => 'dropdown',
            //      'placeholder' => 'Select user group',
            // ],
            'isPublished' => [
                 'title'       => 'Published',
                 'description' => 'Display only Published Courses',
                 'type'        => 'checkbox',
                 'required'    => true,
                 'default'     => true,
            ],
            'coursePage' => [
                 'title'             => 'Course Page',
                 'description'       => 'Course details page',
                 'default'           => 'course',
                 'type'              => 'dropdown',
                 'required'          => 'true',
            ],
        ];
    }

    public function onRun() {

        $this->addJs('/plugins/ovalsoft/courses/assets/css/courses.css');

        $this->page['coursePage'] = $this->property('coursePage', 'course');

        $courses = CourseModel::all();
        $this->page['courses'] = $courses;
        
    }

    /**
     * Get group options
     */
    public function getGroupOptions() {
        return UserGroup::pluck('name', 'code')->toArray();
    }

    public function getCoursePageOptions() {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
}
