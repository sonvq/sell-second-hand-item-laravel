<?php

namespace Modules\Country\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Country\Entities\Country;
use Modules\Country\Http\Requests\CreateCountryRequest;
use Modules\Country\Http\Requests\UpdateCountryRequest;
use Modules\Country\Repositories\CountryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\City\Entities\City;

class CountryController extends AdminBaseController
{
    /**
     * @var CountryRepository
     */
    private $country;

    public function __construct(CountryRepository $country)
    {
        parent::__construct();

        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $countries = $this->country->all();

        return view('country::admin.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('country::admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCountryRequest $request
     * @return Response
     */
    public function store(CreateCountryRequest $request)
    {
        $this->country->create($request->all());

        return redirect()->route('admin.country.country.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('country::countries.title.countries')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Country $country
     * @return Response
     */
    public function edit(Country $country)
    {
        return view('country::admin.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Country $country
     * @param  UpdateCountryRequest $request
     * @return Response
     */
    public function update(Country $country, UpdateCountryRequest $request)
    {
        $this->country->update($country, $request->all());

        return redirect()->route('admin.country.country.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('country::countries.title.countries')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Country $country
     * @return Response
     */
    public function destroy(Country $country)
    {
        // Delete all cities of that country
        $cityList = City::where('country_id', $country->id)->delete();
        
        $this->country->destroy($country);

        return redirect()->route('admin.country.country.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('country::countries.title.countries')]));
    }
}
