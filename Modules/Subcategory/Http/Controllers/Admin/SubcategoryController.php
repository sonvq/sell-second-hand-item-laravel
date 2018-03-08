<?php

namespace Modules\Subcategory\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Subcategory\Http\Requests\CreateSubcategoryRequest;
use Modules\Subcategory\Http\Requests\UpdateSubcategoryRequest;
use Modules\Subcategory\Repositories\SubcategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Item\Entities\Item;
use Modules\Appuser\Entities\AppuserPersonalization;
use Modules\Broadcast\Entities\BroadcastInterest;

class SubcategoryController extends AdminBaseController
{
    /**
     * @var SubcategoryRepository
     */
    private $subcategory;

    public function __construct(SubcategoryRepository $subcategory, CategoryRepository $category)
    {
        parent::__construct();

        $this->subcategory = $subcategory;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $subcategories = Subcategory::with(['category'])->get();

        return view('subcategory::admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $emptyOption = [
            0 => trans('subcategory::subcategories.label.empty_option_category')
        ];
        $categoryArr = $this->category->getByAttributes([], 'name', 'asc')->pluck('name', 'id')->toArray();
        $categories = ($emptyOption + $categoryArr);
        
        return view('subcategory::admin.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSubcategoryRequest $request
     * @return Response
     */
    public function store(CreateSubcategoryRequest $request)
    {
        $this->subcategory->create($request->all());

        return redirect()->route('admin.subcategory.subcategory.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('subcategory::subcategories.title.subcategories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Subcategory $subcategory
     * @return Response
     */
    public function edit(Subcategory $subcategory)
    {
        $emptyOption = [
            0 => trans('subcategory::subcategories.label.empty_option_category')
        ];
        $categoryArr = $this->category->getByAttributes([], 'name', 'asc')->pluck('name', 'id')->toArray();
        $categories = ($emptyOption + $categoryArr);
        
        return view('subcategory::admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Subcategory $subcategory
     * @param  UpdateSubcategoryRequest $request
     * @return Response
     */
    public function update(Subcategory $subcategory, UpdateSubcategoryRequest $request)
    {
        $this->subcategory->update($subcategory, $request->all());

        return redirect()->route('admin.subcategory.subcategory.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('subcategory::subcategories.title.subcategories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Subcategory $subcategory
     * @return Response
     */
    public function destroy(Subcategory $subcategory)
    {
//        // Delete all item
//        Item::where('subcategory_id', $subcategory->id)->delete();
//        
//        // Delete all user personalization
//        AppuserPersonalization::where('subcategory_id', $subcategory->id)->delete();
//        
//        // Delete all broadcast interest
//        BroadcastInterest::where('subcategory_id', $subcategory->id)->delete();
//        
        $this->subcategory->destroy($subcategory);

        return redirect()->route('admin.subcategory.subcategory.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('subcategory::subcategories.title.subcategories')]));
    }
}
