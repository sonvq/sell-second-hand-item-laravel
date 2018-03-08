<?php

namespace Modules\Offer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Offer\Entities\Offer;
use Modules\Offer\Http\Requests\CreateOfferRequest;
use Modules\Offer\Http\Requests\UpdateOfferRequest;
use Modules\Offer\Repositories\OfferRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OfferController extends AdminBaseController
{
    /**
     * @var OfferRepository
     */
    private $offer;

    public function __construct(OfferRepository $offer)
    {
        parent::__construct();

        $this->offer = $offer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$offers = $this->offer->all();

        return view('offer::admin.offers.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('offer::admin.offers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOfferRequest $request
     * @return Response
     */
    public function store(CreateOfferRequest $request)
    {
        $this->offer->create($request->all());

        return redirect()->route('admin.offer.offer.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('offer::offers.title.offers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Offer $offer
     * @return Response
     */
    public function edit(Offer $offer)
    {
        return view('offer::admin.offers.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Offer $offer
     * @param  UpdateOfferRequest $request
     * @return Response
     */
    public function update(Offer $offer, UpdateOfferRequest $request)
    {
        $this->offer->update($offer, $request->all());

        return redirect()->route('admin.offer.offer.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('offer::offers.title.offers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Offer $offer
     * @return Response
     */
    public function destroy(Offer $offer)
    {
        $this->offer->destroy($offer);

        return redirect()->route('admin.offer.offer.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('offer::offers.title.offers')]));
    }
}
