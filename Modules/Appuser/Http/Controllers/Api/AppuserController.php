<?php

namespace Modules\Appuser\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use Modules\User\Entities\Sentinel\User;
use Dingo\Api\Routing\Helpers;
use Modules\Base\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Password;
use App\Common\Helper;
use Modules\Appuser\Repositories\AppuserRepository;
use Modules\Appuser\Repositories\AppuserLoginRepository;
use Modules\City\Entities\City;
use Modules\Appuser\Transformers\AppuserTransformerInterface;
use Modules\Country\Repositories\CountryRepository;
use Modules\Country\Entities\Country;
use Modules\Category\Entities\Category;
use Illuminate\Support\Facades\Mail;
use Modules\Appuser\Entities\Appuser;
use Modules\Appuser\Repositories\AppuserForgotRepository;
use Modules\Appuser\Entities\AppuserForgot;
use Modules\Setting\Repositories\SettingRepository;
use Modules\Promote\Entities\Promote;
use Modules\Subcategory\Entities\Subcategory;
use Validator;
use Modules\Subcategory\Transformers\SubcategoryTransformer;
use Modules\Reporting\Entities\ReportingReason;
use Modules\Discount\Entities\Discount;
use Modules\Appuser\Entities\AppuserActivity;
use Carbon\Carbon;
use Modules\Item\Entities\Item;
use Modules\Appuser\Entities\AppuserPersonalization;
use Modules\Broadcast\Entities\BroadcastInterest;
use Modules\Email\Entities\Email;

class AppuserController extends BaseController
{
    protected $module_name = 'appuser';
            
    public function __construct(Request $request, 
            AppuserRepository $appuserRepository,
            AppuserLoginRepository $appuserLoginRepository,
            CountryRepository $countryRepository,
            AppuserTransformerInterface $appuserTransformer,
            AppuserForgotRepository $appuserForgotRepository,
            SettingRepository $settingRepository)
    {
        
        $this->request = $request;
        $this->appuser_repository = $appuserRepository;
        $this->appuser_login_repository = $appuserLoginRepository;
        $this->appuser_transformer = $appuserTransformer;
        $this->country_repository = $countryRepository;
        $this->appuser_forgot_repository = $appuserForgotRepository;
        $this->setting_repository = $settingRepository;
    }
    
    public function getUserProfile() {            
        $currentLoggedUser = app('logged_user');         
        
        $userObject = $currentLoggedUser->appuser;  
        $userObject->token = $currentLoggedUser->token;
        
        return $this->response->item($userObject, $this->appuser_transformer); 
    }
    
    public function updatePersonalization() {
        $input =  $this->request->all();               
        $currentLoggedUser = app('logged_user');                         
        $userObject = $currentLoggedUser->appuser;         
        
        // Validate appuser registration
        $validate = $this->validateRequest('api-check-appuser-update-personalization', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        $subcategory_id = $input['subcategory_id'];
        if ($subcategory_id == -1) {
            $userObject->personalization_subcategory()->sync([]);
        } else {
            $subcategoryArray = explode(',', $subcategory_id);

            $subCategoryObject = Subcategory::whereIn('id', $subcategoryArray)->get();
            if (count($subCategoryObject) != count($subcategoryArray)) {
                return Helper::notFoundErrorResponse(Helper::SUBCATEGORY_INVALID,
                        Helper::SUBCATEGORY_INVALID_TITLE,
                        Helper::SUBCATEGORY_INVALID_MSG);
            }                                                        
                  
            $userObject->personalization_subcategory()->sync($subcategoryArray);
        }
        $userObject->token = $currentLoggedUser->token;
        
        return $this->response->item($userObject, $this->appuser_transformer); 
    }
    
    public function updateProfile() {
        $input =  $this->request->all();  
        $currentLoggedUser = app('logged_user'); 
        
        $userObject = $currentLoggedUser->appuser;  
        
        $rules = [
            'email' => 'email|max:30|unique:users,email|unique:appuser__appusers,email,' . $userObject->id . '|max:255',
            'username' => 'max:255|unique:appuser__appusers,username,' . $userObject->id,
            'full_name' => 'max:30',            
            'phone_number' => [
                'max:255',
                'unique:appuser__appusers,phone_number,' . $userObject->id,
                'regex:/^\+?\d+$/',
            ],
            'gender' => 'in:male,female',
            'date_of_birth' => 'date|before:18 years ago|date_format:Y-m-d',
            'city_id' => 'exists:city__cities,id',
            'country_id' => 'exists:country__countries,id',
            'avatar' => 'integer|exists:media__files,id',
        ];
        $messages = [
            'password.regex' => 'Password need at least one capital, one special, between 6 and 12 character',
            'email.max' => 'Email address cannot be longer than 30 characters.'
        ];
        
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return Helper::validationErrorResponse($validator);
        }  
   
           
        if (isset($input['city_id']) && !empty($input['city_id']) && isset($input['country_id']) && !empty($input['country_id'])){
            $cityObject = City::find($input['city_id']);
            if ($cityObject) {
                if($cityObject->country_id != $input['country_id']){
                    return Helper::badRequestErrorResponse(Helper::COUNTRY_AND_CITY_NOT_MATCH,
                            Helper::COUNTRY_AND_CITY_NOT_MATCH_TITLE,
                            Helper::COUNTRY_AND_CITY_NOT_MATCH_MSG);
                }
            }
        }
        
        // Successfull validated data, start to create new appuser
        $updatedUser = $this->appuser_repository->update($userObject, $this->request->except(['avatar']));
        
        // Save gallery for item
        if (isset($input['avatar']) && !empty($input['avatar'])) {            
            $arrayToSync = [];
            $fileId = $input['avatar'];
            $arrayToSync[$fileId] = ['imageable_type' => Appuser::class, 'zone' => Appuser::ZONE_APPUSER_AVATAR_IMAGE];
                
            $updatedUser->files()->sync($arrayToSync);
        }        
        
        $updatedUser->token = $currentLoggedUser->token;
      
        return $this->response->item($updatedUser, $this->appuser_transformer);
    }
    
    public function register()
    {
        $input =  $this->request->all();        
        $clientDeviceToken = $this->request->header('DEVICE-TOKEN');
        $clientOS = $this->request->header('DEVICE-TYPE');        
        
        // Validate appuser registration
        $validate = $this->validateRequest('api-check-appuser-register', $input);
        if ($validate !== true) {
            return $validate;
        }

        if (isset($input['city_id']) && !empty($input['city_id']) && isset($input['country_id']) && !empty($input['country_id'])){
            $cityObject = City::find($input['city_id']);
            if ($cityObject) {
                if($cityObject->country_id != $input['country_id']){
                    return Helper::badRequestErrorResponse(Helper::COUNTRY_AND_CITY_NOT_MATCH,
                            Helper::COUNTRY_AND_CITY_NOT_MATCH_TITLE,
                            Helper::COUNTRY_AND_CITY_NOT_MATCH_MSG);
                }
            }
        }
        // Successfull validated data, start to create new appuser
        $createdAppuser = $this->appuser_repository->create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'username' => $input['username'],
            'full_name' => $input['full_name'],            
            'phone_number' => $input['phone_number'],
            'gender' => $input['gender'],
            'date_of_birth' => $input['date_of_birth'],
            'city_id' => $input['city_id'],
            'country_id' => $input['country_id']
        ]);
        

        $token = Password::getRepository()->createNewToken();
        $this->appuser_login_repository->create([
            'appuser_id' => $createdAppuser->id,
            'token' => $token
        ]);

        $appuserReturned = $this->appuser_repository->find($createdAppuser->id);

        if (!empty($clientDeviceToken) && !empty($clientOS)) {            
            $this->storeUserDeviceInfo($clientDeviceToken, $clientOS, $appuserReturned);
        }

        $appuserReturned->token = $token;
        
        // Log register activity
        $userActivity = new AppuserActivity();
        $userActivity->appuser_id = $appuserReturned->id;
        $userActivity->action = AppuserActivity::ACTION_SIGNUP;
        $userActivity->log_time = Carbon::now();
        $userActivity->save();
        
        // Send email welcome
        $welcomeEmail = Email::where('type', Email::TYPE_WELCOME_EMAIL)->where('status', Email::STATUS_PUBLISH)->first();
        if ($welcomeEmail) {
            $content = $welcomeEmail->content;
            $search = ['[username]', '[full_name]'];
            $replaceWith = [$appuserReturned->username, $appuserReturned->full_name];
            $newContent = str_replace($search, $replaceWith, $content);            
            
            $subject = $welcomeEmail->subject;
            $subject = str_replace('[username]', $appuserReturned->username, $subject);
                        
            Mail::send('appuser::frontend.mail.mail_template', ['content' => $newContent], function ($m) use ($input, $subject) {
                $m->to($input['email'])->subject($subject);
            });
            if (Mail::failures()) {
                return Helper::internalServerErrorResponse(Helper::FAIL_TO_SEND_EMAIL,
                            Helper::FAIL_TO_SEND_EMAIL_TITLE,
                            Helper::FAIL_TO_SEND_EMAIL_MSG);
            } 
        }
        
        return $this->response->item($appuserReturned, $this->appuser_transformer); 
    }
    
    public function settings() {

        $objectData = new \stdClass();
        
        // Country and city Listing
        $objectData->country_list = Country::select('id', 'name')->with(['city_list' => function($query){
            $query->select('id', 'name', 'country_id')->orderBy('name', 'asc');
        }])->orderBy('name', 'asc')->get();
        
        // Reporting reason listing
        $objectData->reporting_reasons_list = ReportingReason::select('id', 'name')
                ->orderBy('name', 'asc')->get();
        
        // Discount percentage package
        $objectData->discount_percentage_package = Discount::select('id', 'discount_percent')
                ->orderBy('discount_percent', 'asc')->get();
        

        $categoryList = Category::select('id', 'name', 'status')
                ->where('status', 'publish')->orderBy('name', 'asc')->get();
        
        $categoryIdArr = [];
        $subcategoryArrForCategory = [];
        if (count($categoryList) > 0) {
            foreach ($categoryList as $singleCategory) {
                $categoryIdArr[] = $singleCategory->id;      
                $subcategoryArrForCategory[$singleCategory->id] = [];
            }
        }
        
        if (count($categoryIdArr) > 0) {            
            $subcategory = Subcategory::whereIn('category_id', $categoryIdArr)
                    ->where('status', 'publish')
                    ->orderBy('name', 'asc')->get();
            if (count($subcategory) > 0) {
                foreach ($subcategory as $singleSubCategory) {
                    $subcategoryTransformer = new SubcategoryTransformer();
                    $subcategoryArrForCategory[$singleSubCategory->category_id][] = $subcategoryTransformer->transform($singleSubCategory);
                }
            }            
        }
        
        if (count($categoryList) > 0) {
            foreach ($categoryList as $singleCategory) {
                $singleCategory->subcategory_list = $subcategoryArrForCategory[$singleCategory->id];
            }
        }
            
        $objectData->category_list = $categoryList;
        
        $promoteMethod = 'social_promote';
        $settings = $this->setting_repository->all();        
        
        // Promote method
        if (isset($settings['item::share-social-or-promote-in-list'])) {
            $promoteObject = $settings['item::share-social-or-promote-in-list'];
            $promoteMethod = (string)$promoteObject['plainValue'];
        } 
        $objectData->promote_method = $promoteMethod;
        
        $durationDisplay = 24;
        if (isset($settings['item::duration-display-for-promote'])) {
            $durationObject = $settings['item::duration-display-for-promote'];
            $durationDisplay = (int)$durationObject['plainValue'];
        } 
        $objectData->duration_display = $durationDisplay;
        $objectData->duration_display_message = "Your item is successfully "
                . "promoted on the home screen and it will display on top of the screen for about $durationDisplay hours per day!";
        
        // Promte payment package
        $allPromote = Promote::all();
        if (count($allPromote) > 0) {
            foreach ($allPromote as $singlePromote) {
                $singlePromote->text_display =  'MMK ' . $singlePromote->price_amount . ' for ' . $singlePromote->number_of_date_expired . ' days';
            }
        }
        $objectData->promote_package = $allPromote;
        
        $result = [
            'data' => $objectData
        ];
        
        return $this->response->array($result);  
    }
    
    public function forgotPassword() {
        $input = $this->request->all();
        
        // Validate login
        $validateType = $this->validateRequest('api-check-forgot-password', $input);
        if ($validateType !== true) {
            return $validateType;
        }                
                
        $token  = Password::getRepository()->createNewToken();
        
        $emailAddress = $input['email'];
        $appuserObject = $this->appuser_repository->findByAttributes(['email' => $emailAddress]);
        
        if ($appuserObject) {
            // Send email welcome
            $forgotEmail = Email::where('type', Email::TYPE_FORGOT_PASSWORD)->where('status', Email::STATUS_PUBLISH)->first();
            if ($forgotEmail) {
                $content = $forgotEmail->content;
                $searchContent = ['[full_name]', '[username]', '[reset_link]'];
                $resetLink = \URL::to("appuser/reset/$appuserObject->id/$token");
                
                $replaceWithContent = [$appuserObject->full_name, $appuserObject->username, $resetLink];
                $newContent = str_replace($searchContent, $replaceWithContent, $content);            

                $subject = $forgotEmail->subject;                
                
                Mail::send('appuser::frontend.mail.mail_template', ['content' => $newContent], function ($m) use ($input, $subject) {
                    $m->to($input['email'])->subject($subject);
                });
                if (Mail::failures()) {
                    return Helper::internalServerErrorResponse(Helper::FAIL_TO_SEND_EMAIL,
                                Helper::FAIL_TO_SEND_EMAIL_TITLE,
                                Helper::FAIL_TO_SEND_EMAIL_MSG);
                } else {
                    // Save the token for forgot password
                    $this->appuser_forgot_repository->create([
                        'token' => $token,
                        'appuser_id' => $appuserObject->id,
                        'status' => AppuserForgot::STATUS_PENDING
                    ]);

                    return $this->response->array(['data' => trans('appuser::appusers.SUCCESSFUL_SEND_FORGOT_PASSWORD')]);
                }  
            } else {
                Mail::send('appuser::frontend.mail.mail_forgot_password', ['user' => $appuserObject, 'token' => $token], function ($m) use ($input) {
                    $m->to($input['email'])->subject(trans('appuser::appusers.forgot_email.email_title'));
                });
                if (Mail::failures()) {
                    return Helper::internalServerErrorResponse(Helper::FAIL_TO_SEND_EMAIL,
                                Helper::FAIL_TO_SEND_EMAIL_TITLE,
                                Helper::FAIL_TO_SEND_EMAIL_MSG);
                } else {
                    // Save the token for forgot password
                    $this->appuser_forgot_repository->create([
                        'token' => $token,
                        'appuser_id' => $appuserObject->id,
                        'status' => AppuserForgot::STATUS_PENDING
                    ]);

                    return $this->response->array(['data' => trans('appuser::appusers.SUCCESSFUL_SEND_FORGOT_PASSWORD')]);
                }  
            }
        } else {        
            return $this->response->array(['data' => trans('appuser::appusers.SUCCESSFUL_SEND_FORGOT_PASSWORD')]);
        }
    }
    
    public function changePassword() {
        $input = $this->request->all();
        
        $validateType = $this->validateRequest('api-check-change-password', $input);
        if ($validateType !== true) {
            return $validateType;
        } 
        
        $currentLoggedUser = app('logged_user');                             
        
        $userObject = $currentLoggedUser->appuser;
        
        if (!Hash::check($input['now_password'], $userObject->password)) {
            return Helper::badRequestErrorResponse(Helper::WRONG_NOW_PASSWORD,
                Helper::WRONG_NOW_PASSWORD_TITLE,
                Helper::WRONG_NOW_PASSWORD_MSG);
        } else {
            $userObject = $this->appuser_repository->update($userObject, [
                'password' => Hash::make($input['password']),
            ]);
            $userObject->token = $currentLoggedUser->token;
            
            // Send email change password
            $changePassEmail = Email::where('type', Email::TYPE_CHANGE_PASSWORD)->where('status', Email::STATUS_PUBLISH)->first();
            if ($changePassEmail) {
                $content = $changePassEmail->content;
                $searchContent = ['[full_name]'];                
                $replaceWithContent = [$currentLoggedUser->appuser->full_name];
                $newContent = str_replace($searchContent, $replaceWithContent, $content);            

                $subject = $changePassEmail->subject;                
                
                Mail::send('appuser::frontend.mail.mail_template', ['content' => $newContent], function ($m) use ($currentLoggedUser, $subject) {
                    $m->to($currentLoggedUser->appuser->email)->subject($subject);
                });
                if (Mail::failures()) {
                    return Helper::internalServerErrorResponse(Helper::FAIL_TO_SEND_EMAIL,
                                Helper::FAIL_TO_SEND_EMAIL_TITLE,
                                Helper::FAIL_TO_SEND_EMAIL_MSG);
                } 
            }

            return $this->response->item($userObject, $this->appuser_transformer);
        }       
    }   
    
    public function login()
    {
        $input = $this->request->all();
        $clientDeviceToken = $this->request->header('DEVICE-TOKEN');
        $clientOS = $this->request->header('DEVICE-TYPE');
        
        // Validate login
        $validateType = $this->validateRequest('api-check-login', $input);
        if ($validateType !== true) {
            return $validateType;
        }                
                
        $token  = Password::getRepository()->createNewToken();
        
        $emailAddress = $input['email'];
        $appuserObject = $this->appuser_repository->findByAttributes(['email' => $emailAddress]);
        
        if ($appuserObject) {
            if (Hash::check($input['password'], $appuserObject->password)) {
                if ($appuserObject->status == Appuser::STATUS_INACTIVE) {
                    return Helper::permissionDeniedErrorResponse(Helper::ONLY_ACTIVE_USER_ALLOWED, 
                            Helper::ONLY_ACTIVE_USER_ALLOWED_TITLE, 
                            Helper::ONLY_ACTIVE_USER_ALLOWED_MSG);
                }
                
                $this->appuser_login_repository->create([
                    'appuser_id' => $appuserObject->id,
                    'token' => $token
                ]);

                $appuserObject->first_time_login = 0;
                $appuserObject->save();                

                $appuserReturned = $this->appuser_repository->find($appuserObject->id);

                if (!empty($clientDeviceToken) && !empty($clientOS)) {                   
                     $this->storeUserDeviceInfo($clientDeviceToken, $clientOS, $appuserReturned);
                }

                $appuserReturned->token = $token;
                return $this->response->item($appuserReturned, $this->appuser_transformer); 
            }
        }
        
        return Helper::unauthorizedErrorResponse(Helper::LOGIN_FAIL,
                Helper::LOGIN_FAIL_TITLE,
                Helper::LOGIN_FAIL_MSG);
        
    }
    
    public function logout() {
        $currentLoggedUser = app('logged_user');          
        
        $clientDeviceToken = $this->request->header('DEVICE-TOKEN');
        $clientOS = $this->request->header('DEVICE-TYPE');
        if (!empty($clientDeviceToken) && !empty($clientOS)) {
            $this->removeUserDeviceInfo($clientDeviceToken, $clientOS, $currentLoggedUser);
        }
        
        $currentLoggedUser->delete();                
        
        return $this->response->array(['data' => trans('appuser::appusers.SUCCESSFUL_LOGOUT')]);
    }     
    
    public function deleteRedundantSubcategory() {
        $subcategoryIdList = Subcategory::pluck('id')->toArray();
        
        // Delete all item
        Item::whereNotIn('subcategory_id', $subcategoryIdList)->delete();
        
        // Delete all user personalization
        AppuserPersonalization::whereNotIn('subcategory_id', $subcategoryIdList)->delete();
        
        // Delete all broadcast interest
        BroadcastInterest::whereNotIn('subcategory_id', $subcategoryIdList)->delete();
        
        return $this->response->array(['data' => trans('appuser::appusers.SUCCESSFUL_DELETED')]);
    }
    
    public function deleteRedundantCategory() {
        $categoryIdList = Category::pluck('id')->toArray();
        
        // Delete subcategory that does not belongs to existing category list
        Subcategory::whereNotIn('category_id', $categoryIdList)->delete();
        
        Item::whereNotIn('category_id', $categoryIdList)->delete();
        
        $subcategoryIdList = Subcategory::pluck('id')->toArray();
        
        // Delete all item
        Item::whereNotIn('subcategory_id', $subcategoryIdList)->delete();
        
        // Delete all user personalization
        AppuserPersonalization::whereNotIn('subcategory_id', $subcategoryIdList)->delete();
        
        // Delete all broadcast interest
        BroadcastInterest::whereNotIn('subcategory_id', $subcategoryIdList)->delete();
        
        return $this->response->array(['data' => trans('appuser::appusers.SUCCESSFUL_DELETED')]);
    }
    
    public function correctCategoryItem() {
        $itemList = Item::all();
        if (count($itemList) > 0) {
            foreach ($itemList as $singleItem) {
                $subcategoryItem = Subcategory::where('id', $singleItem->subcategory_id)->first();
                if ($subcategoryItem) {
                    $singleItem->category_id = $subcategoryItem->category_id;
                    $singleItem->save();
                }
            }
        }
            
        return $this->response->array(['data' => trans('appuser::appusers.SUCCESSFUL')]);
    }


}

