<?php

namespace Modules\Receipt\Repositories\Eloquent;

use Modules\Receipt\Repositories\ReceiptRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Excel;
use Illuminate\Database\Eloquent\Collection;

class EloquentReceiptRepository extends EloquentBaseRepository implements ReceiptRepository
{
    public function getReceiptExportBackend($input) {
        $query = $this->model;                
                
        if (isset($input['payment_mode']) && !empty($input['payment_mode'])) {
            $query = $query->where('payment_mode', $input['payment_mode']);
        }
       
        if (isset($input['username']) && !empty($input['username'])) {
            $usernameInput = $input['username'];
            $query = $query->whereHas('appuser', function($qr) use ($usernameInput) {
                $qr->where('username', 'LIKE', '%' . $usernameInput . '%');
            });
        }        
        
        if (isset($input['created_at_from']) && !empty($input['created_at_from'])) {
            $dateFrom = \DateTime::createFromFormat('d/m/Y', $input['created_at_from']);
            $dateFromFormatted = $dateFrom->format('Y-m-d 00:00:00');
            $query = $query->where('created_at', '>=', $dateFromFormatted);
        }
        
        if (isset($input['created_at_to']) && !empty($input['created_at_to'])) {
            $dateTo = \DateTime::createFromFormat('d/m/Y', $input['created_at_to']);
            $dateToFormatted = $dateTo->format('Y-m-d 00:00:00');
            $query = $query->where('created_at', '<=', $dateToFormatted);
        }

                
        return $query->get();
    }
    
    public function receiptExportExcel(Collection $receiptCollection) {
        
        $exportedFile = Excel::create(trans('receipt::receipts.title.receipt export file name'), function($excel) use($receiptCollection) {
            $excel->sheet(trans('receipt::receipts.title.receipt export sheet name'), function($sheet) use($receiptCollection) {
                $sheet->loadView('receipt::admin.receipts.export', array('receipts' => $receiptCollection));
            });
        })->export('xls');
        
        return $exportedFile;
    }
}
