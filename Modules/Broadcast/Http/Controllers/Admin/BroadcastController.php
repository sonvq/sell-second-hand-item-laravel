<?php

namespace Modules\Broadcast\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Broadcast\Entities\Broadcast;
use Modules\Broadcast\Http\Requests\CreateBroadcastRequest;
use Modules\Broadcast\Http\Requests\UpdateBroadcastRequest;
use Modules\Broadcast\Repositories\BroadcastRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Subcategory\Entities\Subcategory;
use Modules\City\Entities\City;

class BroadcastController extends AdminBaseController
{
    /**
     * @var BroadcastRepository
     */
    private $broadcast;

    public function __construct(BroadcastRepository $broadcast)
    {
        parent::__construct();

        $this->broadcast = $broadcast;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $broadcasts = Broadcast::with(['city', 'interest', 'city.country'])->get();

       
        return view('broadcast::admin.broadcasts.index', compact('broadcasts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $subcategory = Subcategory::orderBy('name', 'asc')->pluck('name', 'id')->toArray();                       
        $city = City::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $gender = config('asgard.broadcast.config.gender');
        $age_band = config('asgard.broadcast.config.age_band');
        
        return view('broadcast::admin.broadcasts.create', compact(['subcategory', 'city', 'subcategory', 'gender', 'age_band']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBroadcastRequest $request
     * @return Response
     */
    public function store(CreateBroadcastRequest $request)
    {
        $input = $request->all();
        if (isset($input['gender'])) {
            $input['gender'] = implode(',', $input['gender']);    
        }
        
        if (isset($input['age_band'])) {
            $input['age_band'] = implode(',', $input['age_band']);    
        }               
        
        $createdBroadCast = $this->broadcast->create($input);
                                                                                         
        $createdBroadCast->city()->sync($input['cities']);
        
        $subcategoryArr = [];
        if (isset($input['subcategories'])) {
            $subcategoryArr = $input['subcategories'];
        }
        $createdBroadCast->interest()->sync($subcategoryArr);

        return redirect()->route('admin.broadcast.broadcast.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('broadcast::broadcasts.title.broadcasts')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Broadcast $broadcast
     * @return Response
     */
    public function edit(Broadcast $broadcast)
    {
        $subcategory = Subcategory::orderBy('name', 'asc')->pluck('name', 'id')->toArray();                       
        $city = City::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $gender = config('asgard.broadcast.config.gender');
        $age_band = config('asgard.broadcast.config.age_band');
        
        return view('broadcast::admin.broadcasts.edit', compact([
            'broadcast',
            'subcategory',
            'city',
            'gender',
            'age_band']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Broadcast $broadcast
     * @param  UpdateBroadcastRequest $request
     * @return Response
     */
    public function update(Broadcast $broadcast, UpdateBroadcastRequest $request)
    {
        $input = $request->all();
        if (isset($input['gender'])) {
            $input['gender'] = implode(',', $input['gender']);    
        }
        
        if (isset($input['age_band'])) {
            $input['age_band'] = implode(',', $input['age_band']);    
        }  
        
        $broadcastUpdated = $this->broadcast->update($broadcast, $input);

        $subcategoryArr = [];
        if (isset($input['subcategories'])) {
            $subcategoryArr = $input['subcategories'];
        }
        
        $broadcastUpdated->city()->sync($input['cities']);
        $broadcastUpdated->interest()->sync($subcategoryArr);
        
        return redirect()->route('admin.broadcast.broadcast.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('broadcast::broadcasts.title.broadcasts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Broadcast $broadcast
     * @return Response
     */
    public function destroy(Broadcast $broadcast)
    {
        
        $broadcast->city()->sync([]);
        $broadcast->interest()->sync([]);
        
        $this->broadcast->destroy($broadcast);

        return redirect()->route('admin.broadcast.broadcast.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('broadcast::broadcasts.title.broadcasts')]));
    }
}
