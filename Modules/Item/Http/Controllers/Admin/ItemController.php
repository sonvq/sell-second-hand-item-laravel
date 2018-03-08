<?php

namespace Modules\Item\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Item\Entities\Item;
use Modules\Item\Http\Requests\CreateItemRequest;
use Modules\Item\Http\Requests\UpdateItemRequest;
use Modules\Item\Repositories\ItemRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Category\Entities\Category;
use Modules\Subcategory\Entities\Subcategory;


class ItemController extends AdminBaseController
{
    /**
     * @var ItemRepository
     */
    private $item;

    public function __construct(ItemRepository $item)
    {
        parent::__construct();

        $this->item = $item;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = Item::with(['category', 'subcategory', 'appuser', 'gallery'])->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $subcategories = Subcategory::orderBy('name', 'asc')->get();

        return view('item::admin.items.index', compact('items', 'categories', 'subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('item::admin.items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateItemRequest $request
     * @return Response
     */
    public function store(CreateItemRequest $request)
    {
        $this->item->create($request->all());

        return redirect()->route('admin.item.item.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('item::items.title.items')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Item $item
     * @return Response
     */
    public function edit(Item $item)
    {
        return view('item::admin.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Item $item
     * @param  UpdateItemRequest $request
     * @return Response
     */
    public function update(Item $item, UpdateItemRequest $request)
    {
        $this->item->update($item, $request->all());

        return redirect()->route('admin.item.item.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('item::items.title.items')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Item $item
     * @return Response
     */
    public function destroy(Item $item)
    {
        $this->item->destroy($item);

        return redirect()->route('admin.item.item.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('item::items.title.items')]));
    }
    
    /**
     * Export the item list to excel file
     *
     * @return Response
     */
    public function export(Request $request)
    {
        ob_end_clean();
        
        $input = $request->all();
        
        $itemCollection = $this->item->getItemExportBackend($input);
        
        $this->item->itemExportExcel($itemCollection);

        return redirect()->back();
    }
}
