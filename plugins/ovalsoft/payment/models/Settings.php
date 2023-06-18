<?php namespace Ovalsoft\Payment\Models;

use October\Rain\Database\Model;
use RainLab\Location\Models\Country;

class Settings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'ovalsoft_payment_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    /**
     * Validation rules
     */
    public $rules = [
        'paystack_sk_key' => 'required',
        'paystack_pk_key' => 'required'
    ];

	public function getPaystackCountriesOptions(){
		return Country::where('is_enabled', 1)->lists('name', 'code');
	}

	public function getFlutterwaveCountriesOptions(){
		return Country::where('is_enabled', 1)->lists('name', 'code');
	}

	public function getPayuCountriesOptions(){
		return Country::where('is_enabled', 1)->lists('name', 'code');
	}

	public function getRemitaCountriesOptions(){
		return Country::where('is_enabled', 1)->lists('name', 'code');
	}

	public function getPaypalCountriesOptions(){
		return Country::where('is_enabled', 1)->lists('name', 'code');
	}

	public function checkIsAllowed($country, $type){
		return self::get($type.'_is_active') && $this->checkCountryIsAllowed($country, $type);
	}

	private function checkCountryIsAllowed($country, $type){
		if(self::get($type.'_countries') === null)
			return true;

		if(!is_array(self::get($type.'_countries')))
			return true;

		if(is_array(self::get($type.'_countries')) && 
			!empty(self::get($type.'_countries')) && 
			in_array($country, self::get($type.'_countries')))
			return true;

		return;
	}
}
