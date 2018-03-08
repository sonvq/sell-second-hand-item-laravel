<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Exceptions\CommonException;
use App\Common\Helper;
use Modules\Appuser\Repositories\AppuserLoginRepository;
use Modules\Appuser\Entities\AppuserLogin;
use Modules\Appuser\Entities\Appuser;

class ApiUser {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth, 
            AppuserLoginRepository $appuserLoginRepository)
	{
		$this->auth = $auth;
        $this->appuser_login_repository = $appuserLoginRepository;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if(!$request->headers->has('USER-TOKEN')){
            return Helper::unauthorizedErrorResponse(Helper::MISSING_TOKEN,
                    Helper::MISSING_TOKEN_TITLE,
                    Helper::MISSING_TOKEN_MSG);
        }

        $persistence_code = $request->header('USER-TOKEN');
        
        $appuserLoginObject = $this->appuser_login_repository->findByAttributes(['token' => $persistence_code]);
                
        if (!$appuserLoginObject) {
            return Helper::unauthorizedErrorResponse(Helper::INVALID_TOKEN,
                    Helper::INVALID_TOKEN_TITLE,
                    Helper::INVALID_TOKEN_MSG);
        }
        
        $userObject = $appuserLoginObject->appuser;
        if (!$userObject) {
            return Helper::notFoundErrorResponse(Helper::USER_NOT_FOUND,
                    Helper::USER_NOT_FOUND_TITLE,
                    Helper::USER_NOT_FOUND_MSG);
            
        }
        
        if ($userObject->status == Appuser::STATUS_INACTIVE) {
            return Helper::permissionDeniedErrorResponse(Helper::ONLY_ACTIVE_USER_ALLOWED,
                    Helper::ONLY_ACTIVE_USER_ALLOWED_TITLE,
                    Helper::ONLY_ACTIVE_USER_ALLOWED_MSG);
        }
                
        return $next($request);
	}

}
