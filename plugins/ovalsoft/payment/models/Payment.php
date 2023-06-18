<?php namespace Ovalsoft\Payment\Models;

use Model;

/**
 * Model
 */
class Payment extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = [
    //   'user_name'  => 'required',
    //   'user_email' => 'email|required',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ovalsoft_payments_';

    public $implement = ['RainLab.Location.Behaviors.LocationModel'];

    public $jsonable = ['products'];

    public $belongsTo = [
        'user' => 'Rainlab\User\Models\User',
    ];

    
    public static function generateCode() {
        

        // The length we want the unique reference number to be
        $orderNumber_length = 8;

        // A true/false variable that lets us know if we've found a unique reference number or not
        $orderNumber_found = false;

        // Define possible characters. Characters that may be confused such as the letter 'O' and the number zero aren't included
        $possible_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

        // Until we find a unique reference, keep generating new ones
        while (!$orderNumber_found) {

        // Start with a blank reference number
        $orderNumber = "";

        // Set up a counter to keep track of how many characters have currently been added
        $i = 0;

        // Add random characters from $possible_chars to $orderNumber until $orderNumber_length is reached
        while ($i < $orderNumber_length) {

            // Pick a random character from the $possible_chars list
            $char = substr($possible_chars, mt_rand(0, strlen($possible_chars)-1), 1);

            $orderNumber .= $char;

            $i++;

        }

        // Our new unique reference number is generated. Lets check if it exists or not
        $result = self::where('order_number', $orderNumber)->first();

        if (is_null($result)) {

            // We've found a unique number. Lets set the $orderNumber_found variable to true and exit the while loop
            $orderNumber_found = true;

        }

        return $orderNumber;

        }
    }

    
}
