<?php

namespace Modules\Checkout\Http\Controllers;

use Carbon\Carbon;
use App\Lib\MyHelper;
use Illuminate\Http\Request;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Routing\Controller; 
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator; 

class CheckoutNowController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        $transaction_date = Carbon::tomorrow()->format('Y-m-d h:i:s');

        if (session('order_now') != null) {

            $address = MyHelper::get('transaction/address'); 
            if ($address['status'] == 'success') {
                $mainAddressId = null;

                foreach ($address["result"] as $idAddress) {
                    if ($idAddress["main_address"] === 1) {
                        $mainAddressId = $idAddress["id_user_address"];
                        break;
                    }
                }

                if ($mainAddressId !== null) {
                    $id_user_address = $mainAddressId;
                } else {
                    $id_user_address = 0;
                }

                if (isset(session('order_now')['id_product_serving_method'])) {
                    $items = [
                        "items" => [
                            [
                                "id_outlet" => session('order_now')['outlet'],
                                "id_user_address" => $id_user_address,
                                "transaction_date" => $transaction_date,
                                "items" => [
                                    [
                                        "id_product" => session('order_now')['id_product'],
                                        'qty' => session('order_now')['qty'],
                                        "custom" => 1,
                                        "id_product_serving_method" => session('order_now')['id_product_serving_method'],
                                        "item" => session('order_now')['item'],
                                    ]
                                ]
                            ]
                        ]
                    ];
                    $type = 'box';
                } else {
                    $items = [
                        'id_user_address' => $id_user_address,
                        'items' => [[
                            'id_outlet' => session('order_now')['outlet'],
                            'transaction_date' =>  $transaction_date,
                            'items' => [[
                                'id_product' => session('order_now')['id_product'],
                                'qty' => session('order_now')['qty'],
                                "custom" => 0,
                            ]]
                        ]]
                    ];
                    $type = 'product';
                }

                $itemCheckout = MyHelper::post('transaction/check', $items);
                $payment = MyHelper::post('transaction/available-payment', []);
                $dana = MyHelper::post('setting/sumber-dana', []);

                if ($itemCheckout['status'] == 'success' && $payment['status'] == 'success' && $dana['status'] == 'success') {
                    $data = [
                        'checkout' => $itemCheckout['result'],
                        'payment' => $payment['result'],
                        'address' => $address['result'],
                        'dana' => $dana['result'],
                        'type' => $type,
                        'title' => 'Checkout',
                        'breadcrumb' => [
                            'items' => [
                                1 => [
                                    'title' => 'Home',
                                    'link' => '/'
                                ],
                                2 => [
                                    'title' => 'Keranjang',
                                    'link' => '/cart'
                                ],
                                3 => [
                                    'title' => 'Checkout',
                                    'link' => ''
                                ]
                            ], 
                        ]
                    ];

                    if ($itemCheckout['result']['error_messages'] != null) {
                        Alert::error('Maaf', $itemCheckout['result']['error_messages']);
                    }

                    return view('checkout::ordernow.index', compact('data'));
                }
                return abort('404');
            } else {
                return redirect('address')
                    ->withInput()
                    ->with([
                        'error' => 'Tambahkan alamat terlebih dahulu!'
                    ]);
            }
        }
        return redirect('/');
    }

    public function order(Request $request)
    {
        if ($request->id_product_serving_method) {
            $validator = Validator::make($request->all(), [
                'id_product'     => 'required',
                'quality'     => 'required',
                'outlet'     => 'required',
                'id_product_serving_method' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $form = [
                'id_product' => $request->id_product,
                'qty' => $request->quality,
                'outlet' => $request->outlet,
                'custom' => 1,
                'id_product_serving_method' => $request->id_product_serving_method,
                "item" => explode(", ", $request->item_product)
            ];
            session(['order_now' => $form]);
        } else {
            $validator = Validator::make($request->all(), [
                'id_product'     => 'required',
                'quality'     => 'required',
                'outlet'     => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $form = [
                'id_product' => $request->id_product,
                'qty' => $request->quality,
                'outlet' => $request->outlet,
                'custom' => '0'
            ];
            session(['order_now' => $form]);
        }
    }
}
