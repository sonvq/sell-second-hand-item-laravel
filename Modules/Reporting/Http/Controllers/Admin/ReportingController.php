<?php

namespace Modules\Reporting\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Reporting\Entities\Reporting;
use Modules\Reporting\Http\Requests\CreateReportingRequest;
use Modules\Reporting\Http\Requests\UpdateReportingRequest;
use Modules\Reporting\Repositories\ReportingRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ReportingController extends AdminBaseController
{
    /**
     * @var ReportingRepository
     */
    private $reporting;

    public function __construct(ReportingRepository $reporting)
    {
        parent::__construct();

        $this->reporting = $reporting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reportings = Reporting::with(['sender', 'receiver', 'reporting_reason', 'item'])->get();

        return view('reporting::admin.reportings.index', compact('reportings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('reporting::admin.reportings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateReportingRequest $request
     * @return Response
     */
    public function store(CreateReportingRequest $request)
    {
        $this->reporting->create($request->all());

        return redirect()->route('admin.reporting.reporting.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('reporting::reportings.title.reportings')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Reporting $reporting
     * @return Response
     */
    public function edit(Reporting $reporting)
    {
        return view('reporting::admin.reportings.edit', compact('reporting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Reporting $reporting
     * @param  UpdateReportingRequest $request
     * @return Response
     */
    public function update(Reporting $reporting, UpdateReportingRequest $request)
    {
        $this->reporting->update($reporting, $request->all());

        return redirect()->route('admin.reporting.reporting.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('reporting::reportings.title.reportings')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reporting $reporting
     * @return Response
     */
    public function destroy(Reporting $reporting)
    {
        $this->reporting->destroy($reporting);

        return redirect()->route('admin.reporting.reporting.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('reporting::reportings.title.reportings')]));
    }
}
