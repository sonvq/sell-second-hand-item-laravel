<?php

namespace Modules\Appuser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Appuser\Entities\Appuser;
use Modules\Appuser\Http\Requests\CreateAppuserRequest;
use Modules\Appuser\Http\Requests\UpdateAppuserRequest;
use Modules\Appuser\Repositories\AppuserRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Appuser\Http\Requests\ResetCompleteRequest;
use Modules\Appuser\Entities\AppuserForgot;
use Carbon\Carbon;
use Hash;

class AppuserController extends AdminBaseController
{   
    
    public function getResetComplete($userId, $token)
    {                       
        return view('appuser::public.reset.complete');
    }

    public function postResetComplete($userId, $token, ResetCompleteRequest $request)
    {
        $appuserObject = Appuser::where('id', $userId)->first(); 
        
        if (!$appuserObject) {
            return redirect()->back()->withInput()
                ->withError(trans('appuser::appusers.user_no_longer_exists'));
        }

        $forgotTokenObject = AppuserForgot::where('status', AppuserForgot::STATUS_PENDING)
                ->where('appuser_id', $userId)
                ->where('token', $token)->get();
        
        if (count($forgotTokenObject) == 0) {
            return redirect()->back()->withInput()
                    ->withError(trans('appuser::appusers.invalid_reset_code'));
        }
        
        $input = $request->all();
        // Mark the token as completed
        AppuserForgot::where('status', AppuserForgot::STATUS_PENDING)
                ->where('appuser_id', $userId)
                ->where('token', $token)
                ->update([
                    'status' => AppuserForgot::STATUS_COMPLETED,
                    'completed_at' => Carbon::now()
                ]);
        
        // Update new password to appuser
        $appuserObject->password = Hash::make($input['password']);
        $appuserObject->save();

        return redirect()->back()
            ->withSuccess(trans('appuser::appusers.password_reset'));
    }
}
