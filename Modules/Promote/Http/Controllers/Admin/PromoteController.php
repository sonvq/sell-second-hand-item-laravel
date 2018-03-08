<?php

namespace Modules\Promote\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Promote\Entities\Promote;
use Modules\Promote\Http\Requests\CreatePromoteRequest;
use Modules\Promote\Http\Requests\UpdatePromoteRequest;
use Modules\Promote\Repositories\PromoteRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PromoteController extends AdminBaseController
{
    /**
     * @var PromoteRepository
     */
    private $promote;

    public function __construct(PromoteRepository $promote)
    {
        parent::__construct();

        $this->promote = $promote;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $promotes = $this->promote->all();

        return view('promote::admin.promotes.index', compact('promotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('promote::admin.promotes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePromoteRequest $request
     * @return Response
     */
    public function store(CreatePromoteRequest $request)
    {
        $this->promote->create($request->all());

        return redirect()->route('admin.promote.promote.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('promote::promotes.title.promotes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Promote $promote
     * @return Response
     */
    public function edit(Promote $promote)
    {
        return view('promote::admin.promotes.edit', compact('promote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Promote $promote
     * @param  UpdatePromoteRequest $request
     * @return Response
     */
    public function update(Promote $promote, UpdatePromoteRequest $request)
    {
        $this->promote->update($promote, $request->all());

        return redirect()->route('admin.promote.promote.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('promote::promotes.title.promotes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Promote $promote
     * @return Response
     */
    public function destroy(Promote $promote)
    {
        $this->promote->destroy($promote);

        return redirect()->route('admin.promote.promote.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('promote::promotes.title.promotes')]));
    }
}
