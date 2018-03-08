<?php

namespace Modules\Notify\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Notify\Entities\Notify;
use Modules\Notify\Http\Requests\CreateNotifyRequest;
use Modules\Notify\Http\Requests\UpdateNotifyRequest;
use Modules\Notify\Repositories\NotifyRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class NotifyController extends AdminBaseController
{
    /**
     * @var NotifyRepository
     */
    private $notify;

    public function __construct(NotifyRepository $notify)
    {
        parent::__construct();

        $this->notify = $notify;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$notifies = $this->notify->all();

        return view('notify::admin.notifies.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('notify::admin.notifies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateNotifyRequest $request
     * @return Response
     */
    public function store(CreateNotifyRequest $request)
    {
        $this->notify->create($request->all());

        return redirect()->route('admin.notify.notify.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('notify::notifies.title.notifies')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Notify $notify
     * @return Response
     */
    public function edit(Notify $notify)
    {
        return view('notify::admin.notifies.edit', compact('notify'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Notify $notify
     * @param  UpdateNotifyRequest $request
     * @return Response
     */
    public function update(Notify $notify, UpdateNotifyRequest $request)
    {
        $this->notify->update($notify, $request->all());

        return redirect()->route('admin.notify.notify.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('notify::notifies.title.notifies')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Notify $notify
     * @return Response
     */
    public function destroy(Notify $notify)
    {
        $this->notify->destroy($notify);

        return redirect()->route('admin.notify.notify.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('notify::notifies.title.notifies')]));
    }
}
