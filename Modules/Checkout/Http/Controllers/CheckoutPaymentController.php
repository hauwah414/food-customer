<?php

namespace Modules\Checkout\Http\Controllers;

use Carbon\Carbon;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator; 

class CheckoutPaymentController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }
 
    public function new(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_purpose'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

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

        foreach ($items['items'] as &$item) {
            $idOutlet = $item["id_outlet"];
            if (isset($address[$idOutlet])) {
                $item["id_user_address"] = $address[$idOutlet];
                $item["transaction_date"] = $date[$idOutlet];
            }
        }

        $notes = $request->note;

        foreach ($items['items'] as &$item) {
            $idOutlet = $item["id_outlet"];
            foreach ($item["items"] as &$product) {
                $idProduct = $product["id_product"];
                $note = $notes[$idOutlet][$idProduct] ?? null;
                $product["note"] = $note[0] ?? null;
            }
        }
        $data = [
            "tujuan_pembelian" => $request->purchase_purpose,
            "sumber_dana" => $request->sumber_dana,
            "items" => $items['items']
        ];
        $newTransaction = MyHelper::post('transaction/new', $data); 
        if (isset($newTransaction) && ($newTransaction['status'] == 'success')) {
            $transaction_receipt_number = $newTransaction['result']['transaction_receipt_number'];
            session()->forget('order_now');
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'data'    => $transaction_receipt_number,
            ]);
        }

        return response()->json([
            'error' => 'Unprocessable Entity',
            'message' => $newTransaction['messages'][0],
        ], 422); 
    }

    public function newOrderNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_purpose'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (isset(session('order_now')['id_product_serving_method'])) {
            $items = [
                "tujuan_pembelian" => $request->purchase_purpose,
                'sumber_dana' => $request->sumber_dana,
                'items' => [[
                    'id_outlet' => session('order_now')['outlet'],
                    'id_user_address' => $request->address,
                    'transaction_date' =>  date("Y-m-d H:i", strtotime($request->transaction_date)),
                    "items" => [
                        [
                            "id_product" => session('order_now')['id_product'],
                            'qty' => session('order_now')['qty'],
                            "custom" => 1,
                            "id_product_serving_method" => session('order_now')['id_product_serving_method'],
                            "note" => $request->note,
                            "item" => session('order_now')['item'],
                        ]
                    ]
                ]]
            ];
        } else {
            $items = [
                "tujuan_pembelian" => $request->purchase_purpose,
                'sumber_dana' => $request->sumber_dana,
                'items' => [[
                    'id_outlet' => session('order_now')['outlet'],
                    'id_user_address' => $request->address,
                    'transaction_date' =>  date("Y-m-d H:i", strtotime($request->transaction_date)),
                    'items' => [[
                        'id_product' => session('order_now')['id_product'], 'qty' => session('order_now')['qty'],
                    ]]
                ]]
            ];
        }
 
        $newTransaction = MyHelper::post('transaction/new', $items);

        if (isset($newTransaction) && ($newTransaction['status'] == 'success')) {
            $transaction_receipt_number = $newTransaction['result']['transaction_receipt_number'];
            session()->forget('order_now');
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'data'    => $transaction_receipt_number,
            ]);
        }

        return response()->json([
            'error' => 'Unprocessable Entity',
            'message' => $newTransaction['messages'][0],
        ], 422);
    }
}