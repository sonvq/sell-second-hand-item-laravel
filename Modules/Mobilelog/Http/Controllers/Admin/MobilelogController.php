<?php

namespace Modules\Mobilelog\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mobilelog\Entities\Mobilelog;
use Modules\Mobilelog\Http\Requests\CreateMobilelogRequest;
use Modules\Mobilelog\Http\Requests\UpdateMobilelogRequest;
use Modules\Mobilelog\Repositories\MobilelogRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class MobilelogController extends AdminBaseController
{
    /**
     * @var MobilelogRepository
     */
    private $mobilelog;

    public function __construct(MobilelogRepository $mobilelog)
    {
        parent::__construct();

        $this->mobilelog = $mobilelog;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $mobilelogs = Mobilelog::with(['appuser'])->get();

        return view('mobilelog::admin.mobilelogs.index', compact('mobilelogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('mobilelog::admin.mobilelogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateMobilelogRequest $request
     * @return Response
     */
    public function store(CreateMobilelogRequest $request)
    {
        $this->mobilelog->create($request->all());

        return redirect()->route('admin.mobilelog.mobilelog.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('mobilelog::mobilelogs.title.mobilelogs')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Mobilelog $mobilelog
     * @return Response
     */
    public function edit(Mobilelog $mobilelog)
    {
        return view('mobilelog::admin.mobilelogs.edit', compact('mobilelog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Mobilelog $mobilelog
     * @param  UpdateMobilelogRequest $request
     * @return Response
     */
    public function update(Mobilelog $mobilelog, UpdateMobilelogRequest $request)
    {
        $this->mobilelog->update($mobilelog, $request->all());

        return redirect()->route('admin.mobilelog.mobilelog.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('mobilelog::mobilelogs.title.mobilelogs')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Mobilelog $mobilelog
     * @return Response
     */
    public function destroy(Mobilelog $mobilelog)
    {
        $this->mobilelog->destroy($mobilelog);

        return redirect()->route('admin.mobilelog.mobilelog.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('mobilelog::mobilelogs.title.mobilelogs')]));
    }
}
