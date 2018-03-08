<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use Carbon\Carbon;
use App\Common\Helper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App::singleton('logged_user', function(){
            return Helper::getLoggedUser();
        });
        
        //
        Validator::extend('image_extension', function ($attribute, $value, $parameters, $validator) {                        
            if (!empty($value) && method_exists($value, 'getClientOriginalExtension')) {
                $arrayAllowedExtension = ['jpg', 'png', 'jpeg', 'gif'];

                if ($value->getClientOriginalExtension() == "" || !in_array(strtolower($value->getClientOriginalExtension()), $arrayAllowedExtension)) {
                    return false;
                }
            }
            return true;            
        });
        
        Validator::replacer('image_extension', function ($message, $attribute, $rule, $parameters) {
            
            return str_replace([':attribute'], $parameters, $message);
            
        });
        
        Validator::extend('after_field', function ($attribute, $value, $parameters, $validator) {  
            $data = $validator->getData();

            $dateTo = \DateTime::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            $dateFrom = \DateTime::createFromFormat('d/m/Y', $data[$parameters[0]])->format('Y-m-d');
            
            return Carbon::parse($dateTo) >= Carbon::parse($dateFrom);           
        });
        
        
        Validator::extend('bigger_than', function ($attribute, $value, $parameters, $validator) {                           
            if ($value <= $parameters[0]) {
                return false;
            }
            return true;            
        });
        
        Validator::replacer('bigger_than', function ($message, $attribute, $rule, $parameters) {                        
            return str_replace(':parameters', $parameters[0], $message);
            
        });
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() === 'local') {
            $this->app->register('\Barryvdh\Debugbar\ServiceProvider');
        }
        
        if (env('APP_DEBUG') == true) {
			\DB::connection()->enableQueryLog();
		}
    }
}
