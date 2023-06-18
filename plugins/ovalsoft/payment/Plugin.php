<?php namespace Ovalsoft\Payment;

use System\Classes\PluginBase;
use Backend;
use Carbon\Carbon;
use Event;
use Ovalsoft\Payment\Models\Payment as PaymentModel;
use Rainlab\User\Models\User as UserModel;
use Rainlab\User\Controllers\Users as UsersController;
use Rainlab\User\Models\UserGroup as UserGroupModel;
use Rainlab\User\Controllers\UserGroups as UserGroupsController;
use Pixel\Shop\Classes\Cart;
use DB;
use Mail;


class Plugin extends PluginBase
{
    public $require = ['Rainlab.User'];

    public function pluginDetails()
    {
        return [
            'name' => 'Payment',
            'description' => 'Payments Component.',
            'author' => 'Ovalsoft Technologies',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
    	return [
    		'Ovalsoft\Payment\Components\Payment' => 'Payment'
    	];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Payment',
                'description' => 'Manage available payments (Payment supported for now).',
                'category'    => 'Payments',
                'icon'        => 'icon-globe',
                'class'       => 'Ovalsoft\Payment\Models\Settings',
                // 'url'         => Backend::url('ovalsoft/payment/payments/'),
                'order'       => 500,
                'keywords'    => 'payment payment',
                'permissions' => ['ovalsoft.payment.view_payments'],
            ]
        ];
    }

    public function boot() {

        $this->extendsUserModel();
        $this->extendsUserGroupsController();
        $this->bootExtendPixelShopItems();
        $this->bootExtendPixelShopGatewaysSettings();
        $this->bootExtendPixelShopCoupons();
        
        Event::listen('rainlab.user.register', function ($user, $data) {

            \DB::table('users_groups')->where('user_id', $user->id)->delete();

            $group =  \Rainlab\User\Models\UserGroup::where('code', 'registered')->first();
                    $user->groups()->add($group);
                    $user->save();
        });
    
        Event::listen('ovalsoft.payment.membership.success', function ($user, $payment) {

            \DB::table('users_groups')->where('user_id', $user->id)->delete();

            $group =  \Rainlab\User\Models\UserGroup::where('code', 'paid-users')->first();
                    $user->groups()->add($group);
                    $user->save();

            // Send mail 
            if ($user->email) {
                $vars = ['user' => $user];

                Mail::queue('ovalsoft.courses::mail.membership.upgrade', $vars, function($message) use ($user) {

                    $message->to($user->email);

                });
            }
        });
    
        Event::listen('ovalsoft.payment.courses.success', function ($order, $payment) {
            foreach ($order->items as $item) {
                DB::table('ovalsoft_payment_user_products')->insert([
                    'user_id' => $payment->user_id,
                    'email'   => $payment->user_email,
                    'product_id' => $item['id']
                ]);
            }

            // Send mail 
            if ($payment->user_email) {
                $user = \RainLab\User\Models\User::find($payment->user_id);
                $vars = ['user' => $user, 'order' => $order];

                Mail::queue('ovalsoft.courses::mail.course.purchase', $vars, function($message) use ($payment) {

                    $message->to(['support@havron360.org', $payment->user_email]);

                });
            }
        });

        \Pixel\Shop\Models\Item::extend(function($model) {
            $model->belongsTo['course'] = ['Ovalsoft\Courses\Models\Course', 'key' => 'slug', 'otherKey' => 'slug'];
        });
    
        Event::listen('ovalsoft.payment.paypalsuccess', function ($order) {            
            dd($order);
        });

        Event::listen('backend.menu.extendItems', function($manager) {

            $manager->addSideMenuItems('successivesoftware.paypal', 'shop', [
                'orders' => [
                    'label'       => 'All Orders',
                    'description' => 'Configure available orders.',
                    'icon'        => 'icon-usd',
                    'url'         => Backend::url('successivesoftware/paypal/orders'),
                    'category'    => 'Paypal',
                    'order'       => 500,
                    'permissions' => ['ovalsoft.payment.view_payments']
                ]
            ]);

            // $manager->addMainMenuItems('raccoon.geolocation', [
            //     'settings' => [
            //         'label' => 'Raccoon GeoLocation',
            //         'description' => 'Configure geo location services, API keys and settings.',
            //         'icon' => 'icon-compass',
            //         'url'         => Backend::url('successivesoftware/paypal/orders'),
            //         'class' => Settings::class,
            //         'order' => 500,
            //         'keywords' => 'geolocation ip location country state geo raccoon',
            //         'permissions' => ['ovalsoft.payment.view_payments']
            //     ]
            // ]);

        });

        UsersController::extendFormFields(function($form, $model, $context) {

            if(!$model instanceof UserModel)
                return;

            if(!$model->exists)
                return;

            // Add an extra amount field
            $form->addFields([
                'country' => [
                    'label'   => 'Country',
                ]
            ]);
        });
        
        UsersController::extendListColumns(function($list, $model) {

            if(!$model instanceof UserModel)
                return;

            // Add an extra amount column
            $list->addColumns([
                'country' => [
                    'label' => 'Country',
                ]
            ]);

        });
    }


    public function extendsUserModel() {
        UserModel::extend(function($model) {
            $model->hasMany = [
                'payments' => 'Ovalsoft\Payment\Models\Payment'
            ];
            $model->belongsTo = [
                'country'  => 'RainLab\Location\Models\Country',
                'table'    => 'rainlab_location_countries',
                'key'      => 'country_id',
                'otherKey' => 'id',
            ];
        });
    }


    public function extendsUserGroupsController() {
        UserGroupsController::extendFormFields(function($form, $model, $context) {

            if(!$model instanceof UserGroupModel)
                return;

            if(!$model->exists)
                return;

            // Add an extra amount field
            $form->addFields([
                'amount' => [
                    'label'   => 'Amount',
                    'comment' => 'Enter amount for this package',
                    'type'    => 'number',
                    'span'    => 'full'
                ]
            ]);
        });
        
        UserGroupsController::extendListColumns(function($list, $model) {

            if(!$model instanceof UserGroupModel)
                return;

            // Add an extra amount column
            $list->addColumns([
                'amount' => [
                    'label' => 'Amount'
                ]
            ]);

        });
    }

    public function bootExtendPixelShopItems() {
        
        Event::listen('backend.form.extendFields', function($widget) {

            // Only for the Items controller
            if (!$widget->getController() instanceof \Pixel\Shop\Controllers\Items) {
                return;
            }

            // Only for the Item model
            if (!$widget->model instanceof \Pixel\Shop\Models\Item) {
                return;
            }

            // Add an extra birthday field
            $widget->addSecondaryTabFields([
                'is_virtual' => [
                    'label'   => 'Is Virtual',
                    'comment' => 'Is this a virtual product?',
                    'type'    => 'switch',
                ]
            ]);

        });
    }

    public function bootExtendPixelShopCoupons() {
        
        Event::listen('backend.form.extendFields', function($widget) {

            // Only for the Items controller
            if (!$widget->getController() instanceof \Pixel\Shop\Controllers\Coupons) {
                return;
            }

            // Only for the Item model
            if (!$widget->model instanceof \Pixel\Shop\Models\Coupon) {
                return;
            }

            // Add an extra birthday field
            $widget->addTabFields([
                'user_group_id' => [
                    'label'   => 'User Group',
                    'comment' => 'User Group this coupon should apply to',
                    'type'    => 'dropdown',
                    'tab' => 'User Group',
                    'options' => UserGroupModel::lists('name', 'id')
                ]
            ]);

        });
    }

    public function bootExtendPixelShopGatewaysSettings() {
        
        Event::listen('backend.form.extendFields', function($widget) {

            // Only for the Item model
            if (!$widget->model instanceof \Pixel\Shop\Models\Settings) {
                return;
            }

            // Add an extra birthday field
            $widget->addSecondaryTabFields([
                'is_virtual' => [
                    'label'   => 'Paystack',
                    'type'    => 'section',
                    'tab'     => 'Paystack',
                    'span'    => 'auto',
                ],
                'is_active' => [
                    'label' =>  'pixel.shop::lang.fields.active',
                    'type' =>  'switch',
                    'span' =>  'auto',
                    'tab' =>  'Paystack',
                ],
                'paystack_sk_key' => [
                    'label' => ' Paystack Secret Key',
                    'span' =>  'auto',
                    'commentAbove' => 'Get a Secret Key from https://payment.com/developers',
                    'tab' =>  'Paystack',
                ],
                'paystack_pk_key' =>[
                    'label' =>  'Paystack Public Key',
                    'span' =>  'auto',
                    'commentAbove' => 'Get a Public Key from https://payment.com/developers',
                    'tab' =>  'Paystack',
                ],

            ]);

        });
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'ovalsoft.payment.view_payments' => [
                'tab' => 'Payments',
                'label' => 'View Payments',
                'roles' => ['developer']
            ],
        ];
    }
}
