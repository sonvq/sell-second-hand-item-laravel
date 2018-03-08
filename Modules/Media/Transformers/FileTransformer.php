<?php

namespace Modules\Media\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Media\Entities\File;
use App\Common\Helper;

class FileTransformer extends TransformerAbstract implements FileTransformerInterface {

    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(File $item) {
        
        return [
            'id' => (int) $item->id,
            'description' => (string) $item->description,
            'alt_attribute' => (string) $item->alt_attribute,                
            'keywords' => (string) $item->keywords, 
            'filename' => (string) $item->filename,
            'path' => (string) $item->path,
            'extension' => (string) $item->extension,
            'mimetype' => (string) $item->mimetype,
            'width' => (string) $item->width,
            'height' => (string) $item->height,
            'filesize' => (string) $item->filesize,
            'folder_id' => (int) $item->folder_id,
            'path_string' => (string) $item->path_string,
            'media_type' => (string) $item->media_type,
            
            'thumb_file_url' => (string) $item->thumb_file_url,
            'medium_thumb_file_url' => (string) $item->medium_thumb_file_url,
                   
            'large_url' => (string) $item->large_url,
            'medium_url' => (string) $item->medium_url,
             
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
        ];
    }
}                           


            
            