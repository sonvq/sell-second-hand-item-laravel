<?php

namespace Modules\Base\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use Modules\User\Entities\Sentinel\User;
use Dingo\Api\Routing\Helpers;
use Modules\Base\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Password;
use App\Common\Helper;
use Modules\Appuser\Repositories\AppuserRepository;
use Modules\Appuser\Repositories\AppuserLoginRepository;
use Modules\City\Entities\City;
use Modules\Appuser\Transformers\AppuserTransformerInterface;
use Modules\Country\Repositories\CountryRepository;
use Modules\Country\Entities\Country;
use Modules\Category\Entities\Category;
use Modules\Media\Services\FileService;
use Modules\Media\Repositories\FileRepository;
use Modules\Media\Events\FileWasLinked;
use Modules\Media\Events\FileWasUnlinked;
use Modules\Media\Events\FileWasUploaded;
use Modules\Media\Transformers\FileTransformerInterface;

class FileUploadController extends BaseController
{
    protected $module_name = 'base';
            
    public function __construct(
            Request $request,
            FileService $fileService,
            FileRepository $fileRepository,
            FileTransformerInterface $fileTransformer)
    {
        
        $this->request = $request;
        $this->file_repository = $fileRepository;
        $this->file_service = $fileService;
        $this->file_transformer = $fileTransformer;
    }
    
    public function uploadFile() {
        $input =  $this->request->all();        
                
        $validate = $this->validateRequest('api-check-file-upload', $input);
        if ($validate !== true) {
            return $validate;
        }
        
        $savedFile = $this->file_service->store($this->request->file('file'));

        if (is_string($savedFile)) {
            // Return error upload file
        }

        event(new FileWasUploaded($savedFile));

        return $this->response->item($savedFile, $this->file_transformer); 
    }

}

