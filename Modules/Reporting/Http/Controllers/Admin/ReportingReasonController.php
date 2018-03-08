<?php

namespace Modules\Reporting\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Reporting\Entities\ReportingReason;
use Modules\Reporting\Http\Requests\CreateReportingReasonRequest;
use Modules\Reporting\Http\Requests\UpdateReportingReasonRequest;
use Modules\Reporting\Repositories\ReportingReasonRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ReportingReasonController extends AdminBaseController
{
    /**
     * @var ReportingReasonRepository
     */
    private $reporting_reason;

    public function __construct(ReportingReasonRepository $reportingReason)
    {
        parent::__construct();

        $this->reporting_reason = $reportingReason;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reporting_reasons = $this->reporting_reason->all();

        return view('reporting::admin.reporting-reasons.index', compact('reporting_reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('reporting::admin.reporting-reasons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateReportingReasonRequest $request
     * @return Response
     */
    public function store(CreateReportingReasonRequest $request)
    {
        $this->reporting_reason->create($request->all());

        return redirect()->route('admin.reporting.reporting-reasons.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('reporting::reporting-reasons.title.reporting reasons')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ReportingReason $reporting_reason
     * @return Response
     */
    public function edit(ReportingReason $reporting_reason)
    {
        return view('reporting::admin.reporting-reasons.edit', compact('reporting_reason'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Reporting $reporting_reason
     * @param  UpdateReportingReasonRequest $request
     * @return Response
     */
    public function update(ReportingReason $reporting_reason, UpdateReportingReasonRequest $request)
    {
        $this->reporting_reason->update($reporting_reason, $request->all());

        return redirect()->route('admin.reporting.reporting-reasons.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('reporting::reporting-reasons.title.reporting reasons')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ReportingReason $reporting_reason
     * @return Response
     */
    public function destroy(ReportingReason $reporting_reason)
    {
        $this->reporting_reason->destroy($reporting_reason);

        return redirect()->route('admin.reporting.reporting-reasons.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('reporting::reporting-reasons.title.reporting reasons')]));
    }
}
