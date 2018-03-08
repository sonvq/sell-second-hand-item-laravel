<?php

/**
 * 
 * @author 	
 */

namespace App\Common;

use App\Exceptions\CommonException;
use Illuminate\Support\Facades\Session;
use Modules\Agent\Repositories\Eloquent\EloquentAgentMemberLoginRepository;
use Modules\Agent\Entities\AgentMemberLogin;
use Modules\Core\Contracts\Setting;
use Modules\Media\Entities\Imageable;
use Modules\Media\Events\FileWasUploaded;
use Modules\Authentication\Entities\WasherCustomerLogin;
use Modules\Appuser\Entities\AppuserLogin;

class Helper {
    
    const UNPROCESSABLE_ENTITY = 'UNPROCESSABLE_ENTITY';     
    const UNPROCESSABLE_ENTITY_MSG = 'The given data failed to pass validation';     
    
    const LOGIN_FAIL = 'LOGIN_FAIL';
    const LOGIN_FAIL_TITLE = 'Wrong credentials';
    const LOGIN_FAIL_MSG = 'Invalid email/password';
    
    const MISSING_TOKEN = 'MISSING_TOKEN';
    const MISSING_TOKEN_TITLE = 'Missing token';
    const MISSING_TOKEN_MSG = 'Token is not provided';
    
    const FILE_DOES_NOT_EXIST_OR_DELETED = 'FILE_DOES_NOT_EXIST_OR_DELETED';
    const FILE_DOES_NOT_EXIST_OR_DELETED_TITLE = 'Error message';
    const FILE_DOES_NOT_EXIST_OR_DELETED_MSG = 'There is file that does not exist or has been deleted';
    
    const OFFER_NOT_FOUND = 'OFFER_NOT_FOUND';
    const OFFER_NOT_FOUND_TITLE = 'Error message';
    const OFFER_NOT_FOUND_MSG = 'Offer not found, has been deleted or you already accepted/declined this offer before';
    
    const MAKE_OFFER_NOT_FOUND = 'MAKE_OFFER_NOT_FOUND';
    const MAKE_OFFER_NOT_FOUND_TITLE = 'Error message';
    const MAKE_OFFER_NOT_FOUND_MSG = 'Offer not found or has been deleted';
    
    const CAN_NOT_REPORT_YOURSELF = 'CAN_NOT_REPORT_YOURSELF';
    const CAN_NOT_REPORT_YOURSELF_TITLE = 'Error message';
    const CAN_NOT_REPORT_YOURSELF_MSG = 'You can not report yourself';    
    
    const ALREADY_REPORTED = 'ALREADY_REPORTED';
    const ALREADY_REPORTED_TITLE = 'Error message';
    const ALREADY_REPORTED_MSG = 'Already reported, can not report a user twice for the same reason';            
        
    const FAIL_TO_SEND_EMAIL = 'FAIL_TO_SEND_EMAIL';  
    const FAIL_TO_SEND_EMAIL_TITLE = 'Error message';     
    const FAIL_TO_SEND_EMAIL_MSG = 'Server can not send email, please check with administrator';
    
    const INVALID_TOKEN = 'INVALID_TOKEN';  
    const INVALID_TOKEN_TITLE = 'Invalid token';     
    const INVALID_TOKEN_MSG = 'The given token is invalid';

    const USER_NOT_FOUND = 'USER_NOT_FOUND';  
    const USER_NOT_FOUND_TITLE = 'User not found';     
    const USER_NOT_FOUND_MSG = 'User does not exist or has been deleted';
    
    const NOT_SELLER_OR_BUYER_OFFER = 'NOT_SELLER_OR_BUYER_OFFER';  
    const NOT_SELLER_OR_BUYER_OFFER_TITLE = 'Error message';     
    const NOT_SELLER_OR_BUYER_OFFER_MSG = 'Only buyer or seller of this item are allowed to update';
    
    const NOT_BUYER_OFFER = 'NOT_BUYER_OFFER';  
    const NOT_BUYER_OFFER_TITLE = 'Error message';     
    const NOT_BUYER_OFFER_MSG = 'Only buyer of this offer are allowed to offer again';
    
    const USER_NOT_SELLER_BUYER_OF_ITEM = 'USER_NOT_SELLER_BUYER_OF_ITEM';  
    const USER_NOT_SELLER_BUYER_OF_ITEM_TITLE = 'Error message';     
    const USER_NOT_SELLER_BUYER_OF_ITEM_MSG = 'Only buyer and seller of this item allowed';
    
    const MESSAGE_ALREADY_EXISTED = 'MESSAGE_ALREADY_EXISTED';  
    const MESSAGE_ALREADY_EXISTED_TITLE = 'Error message';     
    const MESSAGE_ALREADY_EXISTED_MSG = 'Message already created';
    
    const CAN_NOT_CHAT_WITH_YOURSELF = 'CAN_NOT_CHAT_WITH_YOURSELF';  
    const CAN_NOT_CHAT_WITH_YOURSELF_TITLE = 'Error message';     
    const CAN_NOT_CHAT_WITH_YOURSELF_MSG = 'You can not chat with yourself';
    
    
    const BUYER_AND_SELLER_CAN_NOT_BE_SAME = 'BUYER_AND_SELLER_CAN_NOT_BE_SAME';  
    const BUYER_AND_SELLER_CAN_NOT_BE_SAME_TITLE = 'Error message';     
    const BUYER_AND_SELLER_CAN_NOT_BE_SAME_MSG = 'Buyer can not be the same with seller';    
    
    const SELLER_ARE_NOT_ITEM_OWNER = 'SELLER_ARE_NOT_ITEM_OWNER';  
    const SELLER_ARE_NOT_ITEM_OWNER_TITLE = 'Error message';     
    const SELLER_ARE_NOT_ITEM_OWNER_MSG = 'Seller is not the owner of this item';    
    
    const ALREADY_OFFERED_THIS_ITEM = 'ALREADY_OFFERED_THIS_ITEM';  
    const ALREADY_OFFERED_THIS_ITEM_TITLE = 'Error message';     
    const ALREADY_OFFERED_THIS_ITEM_MSG = 'You have already offered this item';  
    
    
    const SUBCATEGORY_INVALID = 'SUBCATEGORY_INVALID';  
    const SUBCATEGORY_INVALID_TITLE = 'Error message';     
    const SUBCATEGORY_INVALID_MSG = 'There is invalid or deleted subcategory, please try again later';
    
    
    
    const ONLY_ACTIVE_USER_ALLOWED = 'ONLY_ACTIVE_USER_ALLOWED';  
    const ONLY_ACTIVE_USER_ALLOWED_TITLE = 'Error message';     
    const ONLY_ACTIVE_USER_ALLOWED_MSG = 'Only active user allowed';
    
    const WRONG_NOW_PASSWORD = 'WRONG_NOW_PASSWORD';  
    const WRONG_NOW_PASSWORD_TITLE = 'Error message';     
    const WRONG_NOW_PASSWORD_MSG = 'Current password is not correct';
    
    const ITEM_NOT_FOUND = 'ITEM_NOT_FOUND';  
    const ITEM_NOT_FOUND_TITLE = 'Item not found';     
    const ITEM_NOT_FOUND_MSG = 'Item does not exist or has been deleted';
    
    const MESSAGE_NOT_FOUND = 'MESSAGE_NOT_FOUND';  
    const MESSAGE_NOT_FOUND_TITLE = 'Message not found';     
    const MESSAGE_NOT_FOUND_MSG = 'Message does not exist or has been deleted';
    
    const OWNER_OF_ITEM_REQUIRED = 'OWNER_OF_ITEM_REQUIRED';
    const OWNER_OF_ITEM_REQUIRED_TITLE = 'Error message';
    const OWNER_OF_ITEM_REQUIRED_MSG = 'Only owner of this item is allowed';
    
    const ONLY_BUYER_SELLER_OF_ITEM_ALLOWED = 'ONLY_BUYER_SELLER_OF_ITEM_ALLOWED';
    const ONLY_BUYER_SELLER_OF_ITEM_ALLOWED_TITLE = 'Error message';
    const ONLY_BUYER_SELLER_OF_ITEM_ALLOWED_MSG = 'Only buyer or seller of this item is allowed';
    
    const COUNTRY_AND_CITY_NOT_MATCH = 'COUNTRY_AND_CITY_NOT_MATCH';  
    const COUNTRY_AND_CITY_NOT_MATCH_TITLE = 'Error message';     
    const COUNTRY_AND_CITY_NOT_MATCH_MSG = 'Selected city does not belong to selected country';
    
    const ITEM_SOLD_CAN_NOT_UPDATE = 'ITEM_SOLD_CAN_NOT_UPDATE';  
    const ITEM_SOLD_CAN_NOT_UPDATE_TITLE = 'Error message';     
    const ITEM_SOLD_CAN_NOT_UPDATE_MSG = 'Item has been sold and can not be updated';
    
    const CATEGORY_AND_SUBCATEGORY_NOT_MATCH = 'CATEGORY_AND_SUBCATEGORY_NOT_MATCH';  
    const CATEGORY_AND_SUBCATEGORY_NOT_MATCH_TITLE = 'Error message';     
    const CATEGORY_AND_SUBCATEGORY_NOT_MATCH_MSG = 'Selected subcategory does not belong to selected category';

    public static function getLoggedUser() {
        $persistence_code = request()->header('USER-TOKEN');

        if (!empty($persistence_code)) {
            $appuserLoginObject = AppuserLogin::where('token', $persistence_code)->first();
            if(!empty($appuserLoginObject)) {                
                return $appuserLoginObject;
            }
        }
        return null;        
    }
    
    public static function getToken() {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < 51; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }

    public static function generateRandomPassword() {
        $alphabe = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $number = '1234567890';
        $pass = array();
        $alphaLength = strlen($alphabe) - 1;
        $numberLength = strlen($number) - 1;
        for ($i = 0; $i < 5; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabe[$n];
        }
        for ($i = 0; $i < 3; $i++) {
            $n = rand(0, $numberLength);
            $pass[] = $number[$n];
        }
        shuffle($pass);
        return implode($pass);
    }

    public static function convertLocalTimeToUTC($inputLocalTime) {
        date_default_timezone_set('UTC');
        $dateInLocal = new \DateTime($inputLocalTime, new \DateTimeZone(\Setting::get('core::default-timezone')));
        $dateInLocal->setTimezone(new \DateTimeZone('UTC'));
        $dateInUTC = $dateInLocal->format('Y-m-d H:i:s');
        return $dateInUTC;
    }
    
    public static function currentTimeBySettingConfig($format = 'Y-m-d H:i:s') {
        date_default_timezone_set('UTC');
        $currentDateUTC = new \DateTime(gmdate('Y-m-d H:i:s'), new \DateTimeZone('UTC'));
        $currentDateUTC->setTimezone(new \DateTimeZone(\Setting::get('core::default-timezone')));
        $dateReturn = $currentDateUTC->format($format);
        return $dateReturn;
    }
    
    public static function validationErrorResponse($validation) {

        $errorsMessage = $validation->errors();
        $messageArray = $validation->errors()->all();
        
        $validationArray = [];
        $validationArray['title'] = Helper::UNPROCESSABLE_ENTITY_MSG;
        $validationArray['first_error'] = $messageArray[0];
        $validationArray['details'] = $errorsMessage;        
        
        return Helper::responseFormat(Helper::UNPROCESSABLE_ENTITY, $validationArray, null, true, 422);
    }
    
    public static function unauthorizedErrorResponse ($key, $title, $message) {
        return Helper::commonErrorResponse($key, $title, $message, 401);
    }
    
    public static function badRequestErrorResponse ($key, $title, $message) {
        return Helper::commonErrorResponse($key, $title, $message, 400);
    }
    
    public static function internalServerErrorResponse ($key, $title, $message) {
        return Helper::commonErrorResponse($key, $title, $message, 500);
    }
    
    public static function notFoundErrorResponse ($key, $title, $message) {
        return Helper::commonErrorResponse($key, $title, $message, 404);
    }
    
    public static function permissionDeniedErrorResponse ($key, $title, $message) {
        return Helper::commonErrorResponse($key, $title, $message, 403);
    }


    public static function commonErrorResponse (
            $messageKey = null, 
            $messageTitle = null, 
            $messageContent = null,
            $statusCode = null) {
               
        $errorsMessage = [];
        $errorsMessage['title'] = $messageTitle;
        $errorsMessage['first_error'] = $messageContent;
        $errorsMessage['details'] = null;       
        
         return Helper::responseFormat($messageKey, $errorsMessage, null, true, $statusCode);         
    }


    public static function responseFormat($messageKey = null, 
            $errorsMessage = null, $data = null, $hasError = null, $statusCode = null) {
        
        $result = [
            'message_key' => $messageKey,
            'error_message' => $errorsMessage,
            'data' => $data,
            'has_error'=> $hasError,
            'status_code' => $statusCode,
            'server_time' => time(),
        ];
        
        return response()->json($result, $statusCode);
    }

    public static function getReadableResponseFromGuzzle($response) {
        return json_decode($response->getBody()->__toString());
    }


  
}
