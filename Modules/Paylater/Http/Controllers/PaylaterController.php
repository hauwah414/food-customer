<?php

namespace Modules\Paylater\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class PaylaterController extends Controller
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

        $paylater = MyHelper::post('transaction/group/unpaid', $form);
        $payment = MyHelper::post('transaction/available-payment', []);

        if (($paylater['status'] == 'success') && ($payment['status'] == 'success')) {
            $data = [
                'paylater' => $paylater['result'],
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
            return view('paylater::index', compact('data'));
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

        $paylater = MyHelper::post('transaction/group/pending', $form);

        if ($paylater['status'] == 'success') {
            $data = [
                'paylater' => $paylater['result'],
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
            return view('paylater::index', compact('data'));
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

        $paylater = MyHelper::post('transaction/group/completed', $form);

        $payment = MyHelper::post('transaction/available-payment', []);

        if (($paylater['status'] == 'success') && ($payment['status'] == 'success')) {
            $data = [
                'paylater' => $paylater['result'],
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
            return view('paylater::index', compact('data'));
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
                            'link' => '/paylater'
                        ], 3 => [
                            'title' => 'Detail',
                            'link' => '/'
                        ],
                    ],
                ]
            ];
            // dd($data);
            return view('paylater::show', compact('data'));
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
                return view('paylater::components.table', compact('data'));
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

        if ($request->type == 'paylater') {
            $paylater = MyHelper::post('transaction/group/unpaid', $form);
        } elseif ($request->type == 'waiting') {
            $paylater = MyHelper::post('transaction/group/pending', $form);
        } elseif ($request->type == 'done') {
            $paylater = MyHelper::post('transaction/group/completed', $form);
        }

        $payment = MyHelper::post('transaction/available-payment', []);

        if (($paylater['status'] == 'success') && ($payment['status'] == 'success')) {
            $data = [
                'payment' => $payment['result'],
                'paylater' => $paylater['result'],
            ];
            return view('paylater::components.detail', compact('data'));
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
