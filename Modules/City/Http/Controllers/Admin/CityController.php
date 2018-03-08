<?php

namespace Modules\City\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\CreateCityRequest;
use Modules\City\Http\Requests\UpdateCityRequest;
use Modules\City\Repositories\CityRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Country\Repositories\CountryRepository;

class CityController extends AdminBaseController
{
    /**
     * @var CityRepository
     */
    private $city;

    public function __construct(CityRepository $city, CountryRepository $country)
    {
        parent::__construct();

        $this->city = $city;
        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cities = City::with('country')->get();

        return view('city::admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $emptyOption = [
            0 => trans('city::cities.label.empty_option_country')
        ];
        $countryArr = $this->country->getByAttributes([], 'name', 'asc')->pluck('name', 'id')->toArray();
        $countries = ($emptyOption + $countryArr);
        
        return view('city::admin.cities.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCityRequest $request
     * @return Response
     */
    public function store(CreateCityRequest $request)
    {
        $this->city->create($request->all());

        return redirect()->route('admin.city.city.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('city::cities.title.cities')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  City $city
     * @return Response
     */
    public function edit(City $city)
    {
        $emptyOption = [
            0 => trans('city::cities.label.empty_option_country')
        ];
        $countryArr = $this->country->getByAttributes([], 'name', 'asc')->pluck('name', 'id')->toArray();
        $countries = ($emptyOption + $countryArr);
        
        return view('city::admin.cities.edit', compact('city', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  City $city
     * @param  UpdateCityRequest $request
     * @return Response
     */
    public function update(City $city, UpdateCityRequest $request)
    {
        $this->city->update($city, $request->all());

        return redirect()->route('admin.city.city.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('city::cities.title.cities')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  City $city
     * @return Response
     */
    public function destroy(City $city)
    {
        $this->city->destroy($city);

        return redirect()->route('admin.city.city.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('city::cities.title.cities')]));
    }
}
