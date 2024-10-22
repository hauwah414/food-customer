<?php

namespace Modules\Checkout\Http\Controllers;

use Carbon\Carbon;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Routing\Controller;

class CheckoutAddressController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function change(Request $request)
    {
        $transactionDate = Carbon::tomorrow()->format('Y-m-d h:i:s');
        if (session('cart')) {
            $items = [
                'items' => session('cart')
            ];
        } else {
            $list = MyHelper::post('transaction/cart/list', []);
            if ($list['status'] == 'success') {
                $items = [
                    'items' => $list['result']
                ];
            }
        }

        $address = $request->address;
        $date = $request->date;
        $time = $request->time;

        foreach ($items['items'] as &$item) {
            $idOutlet = $item["id_outlet"];
            if (isset($address[$idOutlet])) {
                $item["id_user_address"] = $address[$idOutlet];
                $item["transaction_date"] = $date[$idOutlet] . $time[$idOutlet];
            }
        }
        $data = [
            "tujuan_pembelian" => $request->purchase_purpose,
            "sumber_dana" => $request->sumber_dana,
            "items" => $items['items']
        ];
 
        $check = MyHelper::post('transaction/check', $data);

        if ($check['status'] == 'success') {
            $data  = $check['result'];
            return view('checkout::component.result-total', compact('data'));
        } else {
            return response()->json([
                'error' => 'Unprocessable Entity',
                'message' => 'Gagal menampilkan biaya kirim',
            ], 422);
        }
    }


    public function changeNow(Request $request)
    {
        $transaction_date = Carbon::tomorrow()->format('Y-m-d h:i:s'); 
        if (isset(session('order_now')['id_product_serving_method'])) {
            $items = [
                'items' => [[
                    'id_outlet' => session('order_now')['outlet'],
                    'id_user_address' => $request->address,
                    'transaction_date' => $transaction_date,
                    "items" => [
                        [
                            "id_product" => session('order_now')['id_product'],
                            'qty' => session('order_now')['qty'],
                            "custom" => 1,
                            "id_product_serving_method" => session('order_now')['id_product_serving_method'],
                            "item" => session('order_now')['item'],
                        ]
                    ]
                ]]
            ];
        } else {
            $items = [
                'items' => [[
                    'id_outlet' => session('order_now')['outlet'],
                    'id_user_address' => $request->address,
                    'transaction_date' => $transaction_date,
                    'items' => [[
                        'id_product' => session('order_now')['id_product'],
                        'qty' => session('order_now')['qty'],
                    ]]
                ]]
            ];
        }
        $check = MyHelper::post('transaction/check', $items);
        if ($check['status'] == 'success') {
            $data  = $check['result'];
            return view('checkout::component.result-total', compact('data'));
        } else {
            return response()->json([
                'error' => 'Unprocessable Entity',
                'message' => 'Gagal menampilkan biaya kirim',
            ], 422);
        }
    }
}
