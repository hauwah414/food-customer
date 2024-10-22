<?php

namespace Modules\Billpayment\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class BillpaymentController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        $this->metaTagLoad(
            [
                'title'     => 'Tagihan Pembayaran',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $form = [
            'filter_status_code' => [2],
            // "date_start" => "",
            // "date_end" => "",
            'page'     => 1,
        ];

        $billpayment = MyHelper::post('transaction/group/unpaid', $form);
        $payment = MyHelper::post('transaction/available-payment', []);

        if (($billpayment['status'] == 'success') && ($payment['status'] == 'success')) {
            $data = [
                'billpayment' => $billpayment['result'],
                'payment' => $payment['result'],
                'title' => 'Notifikasi',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Tagihan Pembayaran',
                            'link' => ''
                        ],
                    ],
                ]
            ];
            return view('billpayment::index', compact('data'));
        }
        return abort(404);
    }


    public function waiting()
    {
        $this->metaTagLoad(
            [
                'title'     => 'Tagihan Pembayaran',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $form = [
            'filter_status_code' => [2],
            'page'     => 1,
        ];

        $billpayment = MyHelper::post('transaction/group/pending', $form);

        if ($billpayment['status'] == 'success') {
            $data = [
                'billpayment' => $billpayment['result'],
                'title' => 'Notifikasi',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Tagihan Pembayaran',
                            'link' => ''
                        ],
                    ],
                ]
            ]; 
            return view('billpayment::index', compact('data'));
        }
        return abort(404);
    }

    public function done()
    {
        $this->metaTagLoad(
            [
                'title'     => 'Tagihan Pembayaran',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $form = [
            'filter_status_code' => [2],
            'page'     => 1,
        ];

        $billpayment = MyHelper::post('transaction/group/completed', $form);


        $payment = MyHelper::post('transaction/available-payment', []);
        if (($billpayment['status'] == 'success') && ($payment['status'] == 'success')) {
            $data = [
                'billpayment' => $billpayment['result'],
                'payment' => $payment['result'],
                'title' => 'Notifikasi',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Tagihan Pembayaran',
                            'link' => ''
                        ],
                    ],
                ]
            ];
            return view('billpayment::index', compact('data'));
        }
        return abort(404);
    }
    public function order()
    {
        $this->metaTagLoad(
            [
                'title'     => 'Tagihan Pembayaran',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $form = [
            "date_start" => "",
            "date_end" => "",
            "page" => "1"
        ];

        $billpayment = MyHelper::post('transaction/group/waiting', $form);

        $payment = MyHelper::post('transaction/available-payment', []);

        if (($billpayment['status'] == 'success') && ($payment['status'] == 'success')) {
            $data = [
                'billpayment' => $billpayment['result'],
                'payment' => $payment['result'],
                'title' => 'Notifikasi',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Tagihan Pembayaran',
                            'link' => ''
                        ],
                    ],
                ]
            ];
            return view('billpayment::index', compact('data'));
        }
        return abort(404);
    }

    public function orderDetail($slug)
    {
        $this->metaTagLoad(
            [
                'title'     => 'Tagihan Pembayaran',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $form = [
            "transaction_receipt_number" => $slug,
            // "date_start" => "",
            // "date_end" => "",
            // "page" => "1"
        ];


        $billpayment = MyHelper::post('transaction/group/v2/detail', $form);
        if (($billpayment['status'] == 'success')) {
            $data = [
                'billpayment' => $billpayment['result'],
                'title' => 'Detail Pemesanan',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Tagihan Pembayaran',
                            'link' => '/billpayment'
                        ],
                        3 => [
                            'title' => 'Detail Pemesanan',
                            'link' => ''
                        ],
                    ],
                ]
            ];
            // dd($data);
            return view('billpayment::order-detail', compact('data'));
        }
        return abort(404);
    }

    public function show($slug)
    {
        $this->metaTagLoad(
            [
                'title'     => 'Tagihan Pembayaran Detail',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );

        $detail = MyHelper::post('transaction/group/payment-detail', [
            'transaction_payment_number' => $slug
        ]); 
        if ($detail['status'] == 'success') {
            $data = [
                'detail' => $detail['result'],
                'title' => 'Notifikasi',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Tagihan Pembayaran',
                            'link' => '/billpayment'
                        ], 3 => [
                            'title' => 'Detail',
                            'link' => '/'
                        ],
                    ],
                ]
            ]; 
            return view('billpayment::show', compact('data'));
        }
        return abort(404);
    }

    public function count(Request $request)
    {
        $count = MyHelper::post('transaction/group/count', []);

        if ($count['status'] == 'success') {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil!',
                'data'    => $count['result']
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Kosong!',
            'data'    => 0
        ]);
    }

    public function check(Request $request)
    { 
        if ($request->transaction_number) {
            $check = MyHelper::post('transaction/group/check', [
                'transaction_receipt_number' => $request['transaction_number']
            ]); 
            if ($check['status'] == 'success') {
                $data = $check['result']; 
                return view('billpayment::components.table', compact('data'));
            }
        }

        if ($request->transaction_receipt_number) {
            $check = MyHelper::post('transaction/group/check', [
                'transaction_receipt_number' => $request['transaction_receipt_number']
            ]);
            if ($check['status'] == 'success') {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil!',
                    'data'    => $check['result']['grandtotal_text']
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Kosong!',
            'data'    => 0
        ]);
    }


    public function filter(Request $request)
    {
        $form = [
            'filter_status_code' => [2],
            "date_start" => $request->dateStart,
            "date_end" => $request->dateEnd,
            'page'     => $request->page,
        ];

        if ($request->type == 'billpayment') {
            $billpayment = MyHelper::post('transaction/group/unpaid', $form);
        } elseif ($request->type == 'waiting') {
            $billpayment = MyHelper::post('transaction/group/pending', $form);
        } elseif ($request->type == 'done') {
            $billpayment = MyHelper::post('transaction/group/completed', $form);
        } elseif ($request->type == 'order') {
            $form = [
                'filter_status_code' => [2],
                "date_start" => $request->dateStart,
                "date_end" => $request->dateEnd,
                'page'     => $request->page,
            ];

            $billpayment = MyHelper::post('transaction/group/waiting', $form);
        } 

        $payment = MyHelper::post('transaction/available-payment', []);

        if (($billpayment['status'] == 'success') && ($payment['status'] == 'success')) {
            $data = [
                'payment' => $payment['result'],
                'billpayment' => $billpayment['result'],
            ]; 
            return view('billpayment::components.detail', compact('data'));
        }
    }

    public function confirm(Request $request)
    { 
        $confirm = MyHelper::post('transaction/group/confirm', [
            'transaction_receipt_number' => $request['transaction_number'],
            'payment_gateway' => "Xendit VA",
            'payment_method' => $request['payment_method'],
        ]);
        if ($confirm['status'] == 'success') {
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran Berhasil dilakukan !',
                'data'    => "Pembayaran Berhasil dilakukan"
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Kosong!',
            'data'    => 0
        ]);
    }
}
