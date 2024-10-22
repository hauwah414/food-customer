<?php

namespace Modules\Transaction\Http\Controllers;

use app\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class TransactionController extends Controller
{

    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function index($slug)
    {

        $transaction = MyHelper::POST('transaction/group/detail', [
            'transaction_receipt_number' => $slug,
        ]);

        if ($transaction['status'] == 'success') {
            $this->metaTagLoad(
                [
                    'title'     => 'Transaksi',
                    'alt_title'  => 'ITS FOOD',
                    'description'   => '',
                    'keywords'      => '',
                    'featured_image' => asset('favicon.png'),
                    'canonical_url'      => url(''),
                ]
            );

            $data = [
                'transaction' => $transaction['result'],
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Transaction',
                            'link' => ''
                        ],
                    ]
                ]
            ];
            // return $data;
            return view('transaction::index', compact('data'));
        }
        return abort(404);
    }

    // public function index($id)
    // {

    //     $transaction = MyHelper::POST('transaction/detailVA', [
    //         'id_transaction_group' => $id,
    //     ]);

    //     if ($transaction['status'] == 'success') {
    //         $this->metaTagLoad(
    //             [
    //                 'title'     => 'Transaksi',
    //                 'alt_title'  => 'ITS FOOD',
    //                 'description'   => '',
    //                 'keywords'      => '',
    //                 'featured_image' => asset('favicon.png'),
    //                 'canonical_url'      => url(''),
    //             ]
    //         );

    //         $data = [
    //             'transaction' => $transaction['result'],
    //         ]; 
    //         return view('transaction::index', compact('data'));
    //     }
    //     return abort(404);
    // }

    public function checkTransaction(Request $request)
    { 
        $transaction_date = Carbon::tomorrow()->format('Y-m-d h:i');
        if ($request->custom) {
            $data = [
                "items" => [
                    [
                        "id_outlet" => $request->outlet,
                        "transaction_date" =>  $transaction_date,
                        "items" => [
                            [
                                "id_product" =>  $request->id_product,
                                'qty' =>  $request->quality,
                                "custom" => 1,
                                'note' =>  $request->note,
                                "id_product_serving_method" =>  $request->id_product_serving_method,
                                "item" => explode(", ", $request->item_product)
                            ]
                        ]
                    ]
                ]
            ];
        } else {
            $data = [
                "items" => [
                    [
                        "id_outlet" => $request->outlet,
                        "transaction_date" =>  $transaction_date,
                        "items" => [
                            [
                                "id_product" =>  $request->id_product,
                                'qty' =>  $request->quality,
                                "custom" => 0,
                                'note' =>  $request->note,
                            ]
                        ]
                    ]
                ]
            ];
        }
        $check = MyHelper::post('transaction/check', $data);
        if ($check['status'] == 'success') {
            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data'    => $check['result']
            ]);
        }
    }


    public function confirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_receipt_number'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = MyHelper::post('transaction/order-received', [
            'transaction_receipt_number' => $request->transaction_receipt_number
        ]);
        if ($post['status'] == 'success') {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil!',
                'data'    => $post
            ]);
        }
    }

    public function received(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_receipt_number'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $recived = MyHelper::post('transaction/order-received', [
            'transaction_receipt_number' => $request->transaction_receipt_number
        ]);

        if ($recived['status'] == 'success') {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diselesaikan!',
                'data'    => $recived
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $destroy = MyHelper::post('transaction/cancel', [
            'receipt_number' => $request->transaction
        ]);
        if ($destroy['status'] == 'success') {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibatalkan!',
                'data'    => $destroy
            ]);
        }
        return response()->json([
            'error' => 'Unprocessable Entity',
            'message' => 'Transaksi gagal dibatalkan!',
        ], 422);
    }
}
