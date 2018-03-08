<?php

namespace Modules\Appuser\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Appuser\Entities\Appuser;
use Modules\Appuser\Http\Requests\CreateAppuserRequest;
use Modules\Appuser\Http\Requests\UpdateAppuserRequest;
use Modules\Appuser\Repositories\AppuserRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Reporting\Entities\Reporting;
use Modules\City\Entities\City;
use Modules\Appuser\Entities\AppuserActivity;
use Modules\Item\Entities\Item;

class AppuserController extends AdminBaseController
{
    /**
     * @var AppuserRepository
     */
    private $appuser;

    public function __construct(AppuserRepository $appuser)
    {
        parent::__construct();

        $this->appuser = $appuser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $appusers = Appuser::with(['report_receiver'])->get();
        
        $cities = City::orderBy('name', 'asc')->get();
        
        return view('appuser::admin.appusers.index', compact('appusers', 'cities'));
    }
    
    public function userInfoById(Request $request) {
        $input = $request->all();
        $appuserObject = Appuser::where('id', $input['appuser_id'])->first();
        
        $itemListByUser = Item::where('appuser_id', $input['appuser_id'])->get();
        
        $returnData = [];
        $returnData['user'] = $appuserObject->toArray();
        $returnData['items'] = $itemListByUser;
        return response()->json($returnData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('appuser::admin.appusers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAppuserRequest $request
     * @return Response
     */
    public function store(CreateAppuserRequest $request)
    {
        $this->appuser->create($request->all());

        return redirect()->route('admin.appuser.appuser.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('appuser::appusers.title.appusers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Appuser $appuser
     * @return Response
     */
    public function edit(Appuser $appuser)
    {
        $reportedCase = Reporting::where('receiver_id', $appuser->id)->get();     
        $activities = AppuserActivity::where('appuser_id', $appuser->id)->orderBy('log_time', 'asc')->get();
                
        return view('appuser::admin.appusers.edit', compact('appuser', 'reportedCase', 'activities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Appuser $appuser
     * @param  UpdateAppuserRequest $request
     * @return Response
     */
    public function update(Appuser $appuser, UpdateAppuserRequest $request)
    {
        $this->appuser->update($appuser, $request->all());

        return redirect()->route('admin.appuser.appuser.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('appuser::appusers.title.appusers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Appuser $appuser
     * @return Response
     */
    public function destroy(Appuser $appuser)
    {
        $this->appuser->destroy($appuser);

        return redirect()->route('admin.appuser.appuser.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('appuser::appusers.title.appusers')]));
    }
    
    /**
     * Export the user list to excel file
     *
     * @return Response
     */
    public function export(Request $request)
    {
        ob_end_clean();
        
        $input = $request->all();
        
        $userCollection = $this->appuser->getUserExportBackend($input);
        
        $this->appuser->userExportExcel($userCollection);

        return redirect()->back();
    }
}
