<?php namespace Ovalsoft\Partners\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Partners\Models\Partner as PartnerModel;
use Ovalsoft\Partners\Models\Program as ProgramModel;

class Programs extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Programs List Component',
            'description' => 'Display list of programs for a Partner'
        ];
    }

    public function defineProperties()
    {
        
        return [
            'programPage' => [
                'title'   => 'Program Page',
                'type'    => 'dropdown',
            ],
            'partnerSlug' => [
                'title'       => 'Partner Slug',
                'description' => 'Partner Slug',
                'type'        => 'string',
                'required'    => true,
            ]
        ];
    }
    
    public function onRun() {
        $partner = PartnerModel::where('slug', $this->property('partnerSlug'))->first();
        $this->page['programs'] = ProgramModel::where('partner_id', $partner->id)->get();
    }

    public function getPartnerPageOptions() {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
}
