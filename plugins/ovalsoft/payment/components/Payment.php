<?php namespace Ovalsoft\Payment\Components;

use Cms\Classes\ComponentBase;

use Lang;
use Auth;
use Request;
use ApplicationException;
use October\Rain\Auth\AuthException;
use Cms\Classes\Page;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Models\Settings as UserSettings;
use Exception;
use Ovalsoft\Payment\Classes\Paystack;

use Ovalsoft\Payment\Models\Payment as PaymentModel;
use Ovalsoft\Payment\Models\Settings;
use Rainlab\User\Models\User;
use RainLab\User\Components\Account;
use GuzzleHttp\Client; 
use Flash;
use Redirect;
use Mail;
use Input;
use Validator;
use ValidationException;
use Event;
use RainLab\Location\Models\State;
use RainLab\Location\Models\Country;
use Carbon\Carbon;
use Pixel\Shop\Classes\Cart;
use Log;


class Payment extends ComponentBase
{

  public function componentDetails()
  {
    return [
      'name'        => 'Payment Component',
      'description' => 'Component for all payment payments'
    ];
  }

  public function defineProperties()
  {
    return [];
  }

  public function onRun() {

    $this->page['countries'] = Country::select('name', 'code')->where('is_enabled', 1)->get();
    $this->page['user'] = $this->user();
    $cart = Cart::load();
    $data = input();

    if($user = $this->user()) {
      $cart->user = $user->id;
      $cart->shipping_address = [
        'state' => $user->shipping_address
      ];
      $cart->customer_first_name = $user->name;
      $cart->customer_email = $user->email;
      $cart->customer_phone = $user->phone;
    }

    $cart->save();
    $order = $cart->createOrderFromCart();
  }

  public function onRegister() {

    $account = new Account();
    
    try {

      if (!$account->canRegister()) {
          throw new ApplicationException(Lang::get(/*Registrations are currently disabled.*/'rainlab.user::lang.account.registration_disabled'));
      }

      if ($this->isRegisterThrottled()) {
          throw new ApplicationException(Lang::get(/*Registration is throttled. Please try again later.*/'rainlab.user::lang.account.registration_throttled'));
      }

      /*
       * Validate input
       */
      $data = post();
      $paymentData = ['package', 'amount', 'phone', 'reference', 'payment_trxref'];
      $data = array_diff_key ( $data, array_flip($paymentData) );
      // dd($data);

      if (!array_key_exists('password_confirmation', $data)) {
          $data['password_confirmation'] = post('password');
      }

      $rules = (new UserModel)->rules;

      if ($account->loginAttribute() !== UserSettings::LOGIN_USERNAME) {
          unset($rules['username']);
      }

      $validation = Validator::make($data, $rules);
      if ($validation->fails()) {
          throw new ValidationException($validation);
      }

      /*
       * Record IP address
       */
      if ($ipAddress = Request::ip()) {
          $data['created_ip_address'] = $data['last_ip_address'] = $ipAddress;
      }

      /*
       * Register user
       */
      Event::fire('rainlab.user.beforeRegister', [&$data]);

      $requireActivation = UserSettings::get('require_activation', true);
      $automaticActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_AUTO;
      $userActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_USER;
      $user = Auth::register($data, $automaticActivation);

      Event::fire('rainlab.user.register', [$user, post()]);

      /*
       * Activation is by the user, send the email
       */
      if ($userActivation) {
          $this->sendActivationEmail($user);

          Flash::success(Lang::get(/*An activation email has been sent to your email address.*/'rainlab.user::lang.account.activation_email_sent'));
      }

      /*
       * Automatically activated or not required, log the user in
       */
      if ($automaticActivation || !$requireActivation) {
          Auth::login($user);
      }

      /*
       * Redirect to the intended page after successful sign in
       */
      // return redirect('dashboard');

    }
    catch (Exception $ex) {
        if (Request::ajax()) throw $ex;
        else Flash::error($ex->getMessage());
    }

  }

  public function onSelectCountry() {
    $code = post('country');
    $settings = Settings::instance();
    
    $paymentMethods = [];
    
    if(\is_array($settings->paystack_countries)) {
      if(in_array($code, $settings->paystack_countries)) {
        $paymentMethods[] = 'Paystack';
      }
    }
    
    if(\is_array($settings->flutterwave_countries)) {
      if(in_array($code, $settings->flutterwave_countries)) {
        $paymentMethods[] = 'Flutterwave';
      }
    }
    
    // if(\is_array($settings->payu_countries)) {
    //   if(in_array($code, $settings->payu_countries)) {
    //     $paymentMethods[] = 'Payu';
    //   }
    // }
    
    // if(\is_array($settings->remita_countries)) {
    //   if(in_array($code, $settings->remita_countries)) {
    //     $paymentMethods[] = 'Remita';
    //   }
    // }
    
    // if(\is_array($settings->remita_countries)) {
    //   if(in_array($code, $settings->paypal_countries)) {
    //     $paymentMethods[] = 'Paypal';
    //   }
    // }

    // dd($paymentMethods);
    return [
        '#paymentMethods' => $this->renderPartial('@payment-methods', [
          'methods' => $paymentMethods
        ])
    ];
  }

  public function onSelectPaymentType() {

    $cart = Cart::load();
    $cart->gateway = input('payment_type');
    $cart->save();

    $paymentType = post('payment_type');

    if($paymentType === 'Paystack') {
      return [
          '#paymentForm' => $this->renderPartial('@paystack', [
            'paystack_pk_key' => Settings::get('paystack_pk_key'),
            'user' => $this->user(),
            'cart' => Cart::load(),
          ])
      ];
    }

    if($paymentType === 'Flutterwave') {
      return [
          '#paymentForm' => $this->renderPartial('@flutterwave', [
            'flutterwave_pk_key' => Settings::get('flutterwave_pk_key'),
            'user' => $this->user(),
            'cart' => Cart::load(),
          ]),
      ];
    }

    // if($paymentType === 'Payu') {
    //   return [
    //       '#paymentForm' => $this->renderPartial('@payu', [
    //         'payu_pk_key' => Settings::get('payu_pk_key'),
    //         'user' => $this->user(),
    //         'cart' => Cart::load(),
    //       ]),
    //   ];
    // }

    // if($paymentType === 'Remita') {
    //   return [
    //       '#paymentForm' => $this->renderPartial('@remita', [
    //         'remita_pk_key' => Settings::get('remita_pk_key'),
    //         'user' => $this->user(),
    //         'cart' => Cart::load(),
    //       ]),
    //   ];
    // }

    // if($paymentType === 'Paypal') {
    //   return [
    //       '#paymentForm' => $this->renderPartial('@paypal', [
    //         'paypal_sandbox_account' => Settings::get('paypal_sandbox_account'),
    //         'paypal_client_id' => Settings::get('paypal_client_id'),
    //         'user' => $this->user(),
    //         'cart' => Cart::load(),
    //       ]),
    //   ];
    //   return redirect('paypal');
    // }
  }

  public function onPayment() {
    
    // $rules = [
    //   'name'  => 'required',
    //   'email' => 'email|required',
    // ];

    // $validator = Validator::make($data, $rules);

    // if ($validator->fails()) {
    //       throw new ValidationException($validator);
          
    // }
        
    $cart = Cart::load();
    $data = input();


    if (count($cart->items) < 1)
      return [Flash::error(trans('pixel.shop::lang.messages.empty_cart'))];

    if($user = $this->user()) {
      $cart->user = $user->id;

      $user->phone = input('customer_phone');
      $user->is_ship_same_bill =input('is_ship_same_bill') == 'on' ? true : false;
      $user->shipping_address = input('shipping_address');
      $user->billing_address = input('is_ship_same_bill' == 'on') ? input('shipping_address') : input('billing_address');

      if(input('is_save_for_later'))
        $user->save();

    } else {
      $cart->customer_first_name = input('name');
      $cart->customer_last_name = input('customer_last_name');
      $cart->customer_email = input('email');
      $cart->customer_phone = input('customer_phone');

      $cart->shipping_address = input('shipping_address');
      $cart->billing_address = input('is_ship_same_bill' == 'on') ? input('shipping_address') : input('billing_address');
    }

    $cart->notes = input('notes');
    $cart->custom_fields = input('custom_fields', array());
    $cart->save();
    
    Log::debug(json_encode([
        'shipping' => input('shipping_address'),
        'billing' => input('billing_address')
    ]));

    $order = $cart->createOrderFromCart();

    if($cart->gateway == 'Paystack' || $cart->gateway == 'Flutterwave'){
        $order->gateway = $cart->gateway;
        $order->status = 'paid';
        $order->save();
        $order->sendNotification();
    }

    $payment               = new PaymentModel;
    $payment->reference    = input('reference');
    $payment->user_id      = $cart->user;
    $payment->user_name    = $cart->customer_first_name;
    $payment->user_email   = $cart->customer_email;
    $payment->amount       = input('amount');
    $payment->order_number = $order->id;
    $payment->message      = input('message');
    $payment->type         = 'Shop Purchase';
    $payment->products     = $order->items;
    $payment->created_at   = Carbon::now();
    $payment->save();

    // fire event
    Event::fire('ovalsoft.payment.courses.success', [$order, $payment]);
    
    // clear cart
    Cart::clear();

    return redirect('/order-success/'.$order->id);
  }

  public function user(){
    if (!$user = Auth::getUser())
      return null;

    return $user;
  }

  /**
   * Returns true if user is throttled.
   * @return bool
   */
  protected function isRegisterThrottled() {
      if (!UserSettings::get('use_register_throttle', false)) {
          return false;
      }

      return UserModel::isRegisterThrottled(Request::ip());
  }

}
