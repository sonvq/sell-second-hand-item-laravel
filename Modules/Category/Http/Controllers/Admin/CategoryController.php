<?php

namespace Modules\Category\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CreateCategoryRequest;
use Modules\Category\Http\Requests\UpdateCategoryRequest;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Item\Entities\Item;
use Modules\Appuser\Entities\AppuserPersonalization;
use Modules\Broadcast\Entities\BroadcastInterest;

class CategoryController extends AdminBaseController
{
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(CategoryRepository $category)
    {
        parent::__construct();

        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = $this->category->all();

        return view('category::admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('category::admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest $request
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->category->create($request->all());

        return redirect()->route('admin.category.category.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('category::categories.title.categories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        return view('category::admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Category $category
     * @param  UpdateCategoryRequest $request
     * @return Response
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $this->category->update($category, $request->all());

        return redirect()->route('admin.category.category.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('category::categories.title.categories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
//        // Delete all subcategory of that category
//        $subcategoryIdArr = Subcategory::where('category_id', $category->id)->pluck('id')->toArray();
//        
//        
//        
//        $subcategoryList = Subcategory::where('category_id', $category->id)->delete();
//        Item::where('category_id', $category->id)->delete();
//        
//        /*
//         * Delete related item, personalization and broadcast interest
//         */
//   
//        // Delete all item
//        Item::whereIn('subcategory_id', $subcategoryIdArr)->delete();
//        
//        // Delete all user personalization
//        AppuserPersonalization::whereIn('subcategory_id', $subcategoryIdArr)->delete();
//        
//        // Delete all broadcast interest
//        BroadcastInterest::whereIn('subcategory_id', $subcategoryIdArr)->delete();
        
        $this->category->destroy($category);

        return redirect()->route('admin.category.category.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('category::categories.title.categories')]));
    }
}
