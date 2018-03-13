<?php

namespace Modules\Mobilelog\Http\Controllers\Api;

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
use Carbon\Carbon;
use Modules\Mobilelog\Entities\Mobilelog; 
use Modules\Mobilelog\Transformers\MobilelogTransformerInterface;

class MobilelogController extends BaseController
{
    protected $module_name = 'mobilelog';
            
    public function __construct(
            Request $request,
            MobilelogTransformerInterface $mobilelogTransformer)
    {
        
        $this->request = $request;
        $this->mobilelog_transformer = $mobilelogTransformer;
       
    }
   
    public function store() {
        $input =  $this->request->all();                     
        
        // Validate create new item
        $validate = $this->validateRequest('api-check-mobilelog-create', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        $appuser_id = null;        
        $currentLoggedUser = app('logged_user');        
        if ($currentLoggedUser) {
            $appuser_id = $currentLoggedUser->appuser_id;
        }
        
        
        // Log register activity
        $mobileLog = new Mobilelog();
        $mobileLog->appuser_id = $appuser_id;
        $mobileLog->file_name = $input['file_name'];
        $mobileLog->content = $input['content'];
        $mobileLog->function_name = $input['function_name'];
        $mobileLog->save();
     
        return $this->response->item($mobileLog, $this->mobilelog_transformer); 
    }     
    
  
}

