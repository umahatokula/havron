<?php namespace Ovalsoft\Partners\Components;

use Cms\Classes\ComponentBase;
use Ovalsoft\Partners\Models\Partner as PartnerModel;

class PartnerDetails extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Partner Details Component',
            'description' => 'Displays details on one partner'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'Page Slug',
                'description' => 'page Slug',
                'type'        => 'string',
                'required'    => true,
            ]
        ];
    }
    
    public function onRun() {
        $this->page['partner'] = PartnerModel::where('slug', $this->property('slug'))->first();
    }
}
