<?php

namespace Modules\Base\Events\Handlers;

use Dingo\Api\Event\ResponseWasMorphed;

class CustomResponseBeforeRender {

    public function handle(ResponseWasMorphed $event) {

        if (is_array($event->content)) {
            $real_status_code = $event->response->getStatusCode();
            if ($real_status_code == 200) {
                $event->content['message_key'] = 'SUCCESS';
                $event->content['error_message'] = null;
                $event->content['has_error'] = false;
                $event->content['status_code'] = $real_status_code;
                $event->content['server_time'] = time();                
            }
            
            if(env('APP_DEBUG') === true && is_array($event->content)){                
                $queryLog = \DB::getQueryLog();
                $event->content['debug']['sql'] = $queryLog;
                $event->content['debug']['sql_count'] = count($queryLog);
            }
            
            
        }
    }

}
