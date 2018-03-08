<?php

namespace Modules\Reporting\Http\Controllers\Api;

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
use Illuminate\Support\Facades\Mail;
use Validator;
use Modules\Reporting\Repositories\ReportingRepository;
use Modules\Reporting\Transformers\ReportingTransformerInterface;

class ReportingController extends BaseController
{
    protected $module_name = 'reporting';
            
    public function __construct(Request $request, 
            ReportingRepository $reportingRepository,
            ReportingTransformerInterface $reportingTransformer)
    {
        
        $this->request = $request;
        $this->reporting_repository = $reportingRepository;
        $this->reporting_transformer = $reportingTransformer;
    }
    
    
    public function create() {
        $input =  $this->request->all();               
        $currentLoggedUser = app('logged_user');                             

        $userObject = $currentLoggedUser->appuser;   
        
        // Validate appuser registration
        $validate = $this->validateRequest('api-create-reporting', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        if ($currentLoggedUser->appuser_id == $input['receiver_id']) {
            return Helper::badRequestErrorResponse(Helper::CAN_NOT_REPORT_YOURSELF,
                    Helper::CAN_NOT_REPORT_YOURSELF_TITLE,
                    Helper::CAN_NOT_REPORT_YOURSELF_MSG);
        }
        
        $input['sender_id'] = $currentLoggedUser->appuser_id;
        
        // Find existing report with these 2 people
        $existingReporting = $this->reporting_repository->findByAttributes([
            'sender_id' => $currentLoggedUser->appuser_id,
            'receiver_id' => $input['receiver_id'],
            'reporting_reason_id' => $input['reporting_reason_id']
        ]);
             
        if ($existingReporting) {
            return Helper::badRequestErrorResponse(Helper::ALREADY_REPORTED,
                    Helper::ALREADY_REPORTED_TITLE,
                    Helper::ALREADY_REPORTED_MSG);
        }
        $reporting = $this->reporting_repository->create($input);
        
        return $this->response->item($reporting, $this->reporting_transformer); 
    }    


}

