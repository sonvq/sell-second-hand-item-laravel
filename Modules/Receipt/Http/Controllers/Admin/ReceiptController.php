<?php

namespace Modules\Receipt\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Receipt\Entities\Receipt;
use Modules\Receipt\Http\Requests\CreateReceiptRequest;
use Modules\Receipt\Http\Requests\UpdateReceiptRequest;
use Modules\Receipt\Repositories\ReceiptRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Appuser\Entities\Appuser;

class ReceiptController extends AdminBaseController
{
    /**
     * @var ReceiptRepository
     */
    private $receipt;

    public function __construct(ReceiptRepository $receipt)
    {
        parent::__construct();

        $this->receipt = $receipt;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $receipts = Receipt::with(['appuser', 'item'])->get();
        
        $paymentMode = config('asgard.receipt.config.payment_mode');        
        
        return view('receipt::admin.receipts.index', compact('receipts', 'paymentMode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $appuserList = Appuser::all();
        $appuserArr = [];
        
        $emptyOption = [
            0 => trans('receipt::receipts.label.empty_option_phone_number')
        ];
        
        if (count($appuserList) > 0) {
            foreach ($appuserList as $singleAppUser) {
                $appuserArr[$singleAppUser->id] = $singleAppUser->phone_number;
            }
        }
        
        $appusers = ($emptyOption + $appuserArr);
        
        $items = [
            0 => trans('receipt::receipts.label.empty_option_item_name')
        ];
        
        $paymentModeConfigArr = config('asgard.receipt.config.payment_mode');
        
        $emptyOptionPaymentMode = [
            0 => trans('receipt::receipts.label.empty_option_payment_mode')
        ];
        
        $paymentMode = ($emptyOptionPaymentMode + $paymentModeConfigArr);
        
        return view('receipt::admin.receipts.create', compact('appusers', 'items', 'paymentMode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateReceiptRequest $request
     * @return Response
     */
    public function store(CreateReceiptRequest $request)
    {
        $input = $request->all();
        
        if (isset($input['promo_period_from']) && !empty($input['promo_period_from'])) {
            $dateFrom = \DateTime::createFromFormat('d/m/Y', $input['promo_period_from']);
            $dateFromFormatted = $dateFrom->format('Y-m-d 00:00:00');
            $input['promo_period_from'] = $dateFromFormatted;
            
        }
        
        if (isset($input['promo_period_to']) && !empty($input['promo_period_to'])) {
            $dateTo = \DateTime::createFromFormat('d/m/Y', $input['promo_period_to']);
            $dateToFormatted = $dateTo->format('Y-m-d 00:00:00');
            $input['promo_period_to'] = $dateToFormatted;
        }
        
        $this->receipt->create($input);

        return redirect()->route('admin.receipt.receipt.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('receipt::receipts.title.receipts')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Receipt $receipt
     * @return Response
     */
    public function edit(Receipt $receipt)
    {
        $appuserList = Appuser::all();
        $appuserArr = [];
        
        $emptyOption = [
            0 => trans('receipt::receipts.label.empty_option_phone_number')
        ];
        
        if (count($appuserList) > 0) {
            foreach ($appuserList as $singleAppUser) {
                $appuserArr[$singleAppUser->id] = $singleAppUser->phone_number;
            }
        }
        
        $appusers = ($emptyOption + $appuserArr);
        
        $items = [
            0 => trans('receipt::receipts.label.empty_option_item_name')
        ];
        
        $paymentModeConfigArr = config('asgard.receipt.config.payment_mode');
        
        $emptyOptionPaymentMode = [
            0 => trans('receipt::receipts.label.empty_option_payment_mode')
        ];
        
        $paymentMode = ($emptyOptionPaymentMode + $paymentModeConfigArr);
        
        return view('receipt::admin.receipts.edit', compact('receipt', 'appusers', 'items', 'paymentMode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Receipt $receipt
     * @param  UpdateReceiptRequest $request
     * @return Response
     */
    public function update(Receipt $receipt, UpdateReceiptRequest $request)
    {
        $input = $request->all();
        
        if (isset($input['promo_period_from']) && !empty($input['promo_period_from'])) {
            $dateFrom = \DateTime::createFromFormat('d/m/Y', $input['promo_period_from']);
            $dateFromFormatted = $dateFrom->format('Y-m-d 00:00:00');
            $input['promo_period_from'] = $dateFromFormatted;
            
        }
        
        if (isset($input['promo_period_to']) && !empty($input['promo_period_to'])) {
            $dateTo = \DateTime::createFromFormat('d/m/Y', $input['promo_period_to']);
            $dateToFormatted = $dateTo->format('Y-m-d 00:00:00');
            $input['promo_period_to'] = $dateToFormatted;
        }
        
        $this->receipt->update($receipt, $input);

        return redirect()->route('admin.receipt.receipt.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('receipt::receipts.title.receipts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Receipt $receipt
     * @return Response
     */
    public function destroy(Receipt $receipt)
    {
        $this->receipt->destroy($receipt);

        return redirect()->route('admin.receipt.receipt.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('receipt::receipts.title.receipts')]));
    }
    
    /**
     * Export the receipt list to excel file
     *
     * @return Response
     */
    public function export(Request $request)
    {
        ob_end_clean();
        
        $input = $request->all();
        
        $receiptCollection = $this->receipt->getReceiptExportBackend($input);
        
        $this->receipt->receiptExportExcel($receiptCollection);

        return redirect()->back();
    }
}
