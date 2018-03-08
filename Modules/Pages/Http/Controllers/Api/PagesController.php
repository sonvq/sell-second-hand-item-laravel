<?php

namespace Modules\Pages\Http\Controllers\Api;

use Modules\Base\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Modules\Pages\Repositories\PagesRepository;
use Modules\Pages\Transformers\PagesTransformerInterface;
use Modules\Pages\Entities\Pages;

class PagesController extends BaseController
{
    protected $module_name = 'pages';
            
    public function __construct(Request $request,
            PagesRepository $pagesRepository,
            PagesTransformerInterface $pagesTransformer)
    {
        $this->pages_repository = $pagesRepository;
        $this->request = $request;     
        $this->pages_transformer = $pagesTransformer;                
    }
    
    
    public function index() {              
        $input['status'] = Pages::STATUS_PUBLISH;
        $result['landing_page'] = Pages::where('status', Pages::STATUS_PUBLISH)
                ->where('page_type', Pages::PAGE_TYPE_LANDING)
                ->orderBy('created_at', 'desc')
                ->limit(3)->get();
        
        $result['about_us'] = Pages::where('status', Pages::STATUS_PUBLISH)
                ->where('page_type', Pages::PAGE_TYPE_ABOUT_US)
                ->orderBy('created_at', 'desc')
                ->first();
        $result['terms_conditions'] = Pages::where('status', Pages::STATUS_PUBLISH)
                ->where('page_type', Pages::PAGE_TYPE_TERMS_CONDITIONS)
                ->orderBy('created_at', 'desc')
                ->first();
        
        $resultReturn = [
            'data' => $result
        ];
        
        return $this->response->array($resultReturn); 
    }            

}

