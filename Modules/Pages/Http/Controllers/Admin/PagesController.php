<?php

namespace Modules\Pages\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pages\Entities\Pages;
use Modules\Pages\Http\Requests\CreatePagesRequest;
use Modules\Pages\Http\Requests\UpdatePagesRequest;
use Modules\Pages\Repositories\PagesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PagesController extends AdminBaseController
{
    /**
     * @var PagesRepository
     */
    private $pages;

    public function __construct(PagesRepository $pages)
    {
        parent::__construct();

        $this->pages = $pages;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pages = $this->pages->all();

        return view('pages::admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages::admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePagesRequest $request
     * @return Response
     */
    public function store(CreatePagesRequest $request)
    {
        $this->pages->create($request->all());

        return redirect()->route('admin.pages.pages.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pages::pages.title.pages')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Pages $pages
     * @return Response
     */
    public function edit(Pages $pages)
    {
        return view('pages::admin.pages.edit', compact('pages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Pages $pages
     * @param  UpdatePagesRequest $request
     * @return Response
     */
    public function update(Pages $pages, UpdatePagesRequest $request)
    {
        $this->pages->update($pages, $request->all());

        return redirect()->route('admin.pages.pages.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('pages::pages.title.pages')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Pages $pages
     * @return Response
     */
    public function destroy(Pages $pages)
    {
        $this->pages->destroy($pages);

        return redirect()->route('admin.pages.pages.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pages::pages.title.pages')]));
    }
}
