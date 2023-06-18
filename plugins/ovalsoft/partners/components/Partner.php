<?php namespace Ovalsoft\Partners\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Partners\Models\Partner as PartnerModel;

use Cms\Classes\Page;

class Partner extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Partner Component',
            'description' => 'Display partners on a page'
        ];
    }

    public function defineProperties()
    {
        return [
            'partnerPage' => [
                'title'   => 'Partner Page',
                'type'    => 'dropdown',
            ]
        ];
    }
    
    public function onRun() {
        $this->page['partnerPage'] = $this->property('partnerPage');
        $this->page['partners'] = PartnerModel::where('is_active', 1)->get();
    }

    public function getPartnerPageOptions() {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
}
