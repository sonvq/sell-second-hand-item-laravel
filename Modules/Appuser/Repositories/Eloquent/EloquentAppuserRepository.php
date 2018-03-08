<?php

namespace Modules\Appuser\Repositories\Eloquent;

use Modules\Appuser\Repositories\AppuserRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Excel;
use Illuminate\Database\Eloquent\Collection;
use Modules\Broadcast\Entities\Broadcast;

class EloquentAppuserRepository extends EloquentBaseRepository implements AppuserRepository
{
        
    public function getUserExportBackend($input) {
        $query = $this->model->with(['report_sender']);                
                
        if (isset($input['username']) && !empty($input['username'])) {
            $query = $query->where('username', 'LIKE', '%' . $input['username'] . '%');
        }
        
        if (isset($input['full_name']) && !empty($input['full_name'])) {
            $query = $query->where('full_name', 'LIKE', '%' . $input['full_name'] . '%');
        }
        
        if (isset($input['email']) && !empty($input['email'])) {
            $query = $query->where('email', 'LIKE', '%' . $input['email'] . '%');
        }
        
        if (isset($input['city_id']) && !empty($input['city_id'])) {
            $query = $query->where('city_id', $input['city_id']);
        }
        
        if (isset($input['status']) && !empty($input['status'])) {
            $query = $query->where('status', $input['status']);
        }
        
        if (isset($input['report_user']) && !empty($input['report_user'])) {
            if ($input['report_user'] == 'Y') {               
                $query = $query->has('report_receiver', '>', 0);
            } else if ($input['report_user'] == 'N') { 
                $query = $query->has('report_receiver', '=', 0);
            }
        }
                
        return $query->get();
    }
    
    public function getAppuserMatchingBroadcastGroup($broadcast_id) {        
        $broadcastObject = Broadcast::where('id', $broadcast_id)->with(['interest', 'city'])->first();
        $query = $this->model->with(['personalization_subcategory']);
        
        if (!empty($broadcastObject->gender)) {
            $genderArr = explode(',', $broadcastObject->gender);
            $query = $query->whereIn('gender', $genderArr);
        }
        
        if (count($broadcastObject->interest) > 0) {
            $broadCastInterestId = $broadcastObject->interest->pluck('id')->toArray();
            
            $query = $query->whereHas('personalization_subcategory', function ($query) use ($broadCastInterestId) {
                $query->whereIn('subcategory_id', $broadCastInterestId);
            });
        } else {
            $query = $query->doesnthave('personalization_subcategory');
        }
        
        if (count($broadcastObject->city) > 0) {
            $cityId = $broadcastObject->city->pluck('id')->toArray();
            $query = $query->whereIn('city_id', $cityId);
        }        
        
        if (!empty($broadcastObject->age_band)) {
            $ageBandArr = explode(',', $broadcastObject->age_band);
            if (count($ageBandArr) > 0) {
                $query = $query->where(function($q) use ($ageBandArr){
                    foreach ($ageBandArr as $singleAgeBand) {
                        if ($singleAgeBand == Broadcast::AGE_18_25) {
                            $q->orWhereRaw("((YEAR(NOW()) - YEAR(`date_of_birth`)) BETWEEN 18 AND 25)");       
                        }
                        if ($singleAgeBand == Broadcast::AGE_26_35) {
                            $q->orWhereRaw("((YEAR(NOW()) - YEAR(`date_of_birth`)) BETWEEN 26 AND 35)");       
                        }
                        if ($singleAgeBand == Broadcast::AGE_36_50) {
                            $q->orWhereRaw("((YEAR(NOW()) - YEAR(`date_of_birth`)) BETWEEN 36 AND 50)");       
                        }
                        if ($singleAgeBand == Broadcast::AGE_ABOVE_50) {
                            $q->orWhereRaw("((YEAR(NOW()) - YEAR(`date_of_birth`)) > 50)");       
                        }
                    }
                }); 
            }
        }
        
        $appuserList = $query->get();

        return $appuserList;
    }
    
    public function userExportExcel(Collection $userCollection) {
        
        $exportedFile = Excel::create(trans('appuser::appusers.title.user export file name'), function($excel) use($userCollection) {
            $excel->sheet(trans('appuser::appusers.title.user export sheet name'), function($sheet) use($userCollection) {
                $sheet->loadView('appuser::admin.appusers.export', array('appusers' => $userCollection));
            });
        })->export('xls');
        
        return $exportedFile;
    }
        
}
