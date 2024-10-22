<?php

namespace Modules\Checkout\Http\Controllers;

use Carbon\Carbon;
use App\Lib\MyHelper; 
use App\Http\Traits\MetaTagTraits;
use Illuminate\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        $transactionDate = Carbon::tomorrow()->format('Y-m-d h:i:s');

        if (session('cart')) {
            $items = [
                'items' => session('cart')
            ];

            foreach ($items['items'] as &$item) {
                $item['transaction_date'] = $transactionDate;
            }

            $itemCheckout = MyHelper::post('transaction/check', $items);
        } else {
            $list = MyHelper::post('transaction/cart/list', []);

            if ($list['status'] == 'success') {
                $items = [
                    'items' => $list['result']
                ];

                foreach ($items['items'] as &$item) {
                    $item['transaction_date'] = $transactionDate;
                }

                $itemCheckout = MyHelper::post('transaction/check', $items);
            }
        }

        $payment = MyHelper::post('transaction/available-payment', []);
        $address = MyHelper::get('transaction/address');
        $dana = MyHelper::post('setting/sumber-dana', []);

        if ((isset($itemCheckout)) && ($itemCheckout['status'] == 'success')   && ($payment['status'] == 'success') && ($address['status'] == 'success') && ($dana['status'] == 'success')) {
            $data = [
                'checkout' => $itemCheckout['result'],
                'payment' => $payment['result'],
                'address' => $address['result'],
                'dana' => $dana['result'],
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
            // dd($data);
            return view('checkout::index', compact('data'));
        } elseif ($address['status'] == 'fail') {
            return redirect('address')
                ->withInput()
                ->with([
                    'error' => 'Tambahkan alamat terlebih dahulu!'
                ]);
        } 
        return back();
    }

}
