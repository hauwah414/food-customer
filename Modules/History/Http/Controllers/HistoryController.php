<?php

namespace Modules\History\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use App\Http\Traits\MetaTagTraits;

class HistoryController extends Controller
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
                'title'     => 'Riwayat',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $history = MyHelper::post(
            'transaction/history',
            [
                'filter_status_code' => [3]
            ]
        );

        if ($history['status'] == 'success') {
            $data = [
                'history' => $history['result'], 
                'title' => 'Riwayat Transaksi',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Riwayat',
                            'link' => ''
                        ],
                    ]
                ]
            ]; 
            
            return view('history::index', compact('data'));
        }
        return abort(404);
    }

    public function filter(Request $request)
    {
        $history = MyHelper::post('transaction/history', [
            'filter_status_code' => [
                $request->filter
            ],
            'outlet_name' => $request->outlet_name,
            'transaction_receipt_number' => $request->transaction_receipt_number,
            'transaction_receipt_number_group' => $request->transaction_receipt_number_group,
            'transaction_date' => $request->transaction_date
        ]);

        if ($history['status'] == 'success') {
            $data = [
                'history' => $history['result'],
            ];
            return view('history::components.accordion', compact('data'));
        }
    }

    public function show($slug)
    {
        $detailhistory = MyHelper::post('transaction/detail', ['transaction_receipt_number' => $slug]);
        if ($detailhistory['status'] == 'success') {
            if ($detailhistory['result']['transaction_status_code'] == 2) {
                $historyGroup = MyHelper::post('transaction/group/detail', ['transaction_receipt_number' => $detailhistory['result']['receipt_number_group']]);
                $payment = MyHelper::post('transaction/available-payment', []);

                if ($historyGroup['status'] == 'success' && $payment['status'] == 'success') {
                    $historyGroup = $historyGroup['result'];
                    $payment = $payment['result'];
                }
            }

            if ($detailhistory['status'] == 'success') {
                if (!isset($detailhistory['result']['status'])) {
                    $this->metaTagLoad(
                        [
                            'title'     => 'Riwayat Transaksi',
                            'alt_title'  => 'ITS FOOD',
                            'featured_image' => asset('favicon.png'),
                            'canonical_url'      => url(''),
                        ]
                    );
                    $data = [
                        'history_group' => $historyGroup ?? '',
                        'payment' => $payment ?? '',
                        'history' => $detailhistory['result'],
                        'breadcrumb' => [
                            'items' => [
                                1 => [
                                    'title' => 'Home',
                                    'link' => '/'
                                ],
                                2 => [
                                    'title' => 'History',
                                    'link' => '/history'
                                ],
                                3 => [
                                    'title' => 'Detail',
                                    'link' => ''
                                ],
                            ]
                        ]
                    ]; 
                    return view('history::show', compact('data'));
                }
            }
        }
        return abort(404);
    }

    public function payment(Request $request)
    {
        $formConfirmation = [
            'id' => $request->id_transaction_group,
            'payment_type' => 'Xendit VA',
            'payment_detail' => $request->paymentMethod
        ];

        $confirmation = MyHelper::post('transaction/confirm', $formConfirmation);

        if ($confirmation['status'] == 'success') {
            $id_transaction_group = $confirmation['result']['transaction_data']['transaction_details']['id_transaction_group'];
            session()->forget('order_now');
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dikonfirmasi!',
                'data'    => $id_transaction_group,
            ]);
        }

        return response()->json([
            'error' => 'Unprocessable Entity',
            'message' => 'Transaksi gagal dikonfirmasi!',
        ], 422);
    }
}
