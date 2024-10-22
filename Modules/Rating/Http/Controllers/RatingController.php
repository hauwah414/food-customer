<?php

namespace Modules\Rating\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Lib\MyHelper;
use App\Http\Traits\MetaTagTraits;

class RatingController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function show($slug)
    {

        $transaction = MyHelper::post('transaction/detail', [
            'transaction_receipt_number' => $slug
        ]);

        if ($transaction['status'] == 'success' && $transaction['result']['transaction_status_code'] == 6) {
            $this->metaTagLoad(
                [
                    'title'     => 'Rating',
                    'alt_title'  => 'ITS FOOD',
                    'description'   => '',
                    'keywords'      => '',
                    'featured_image' => asset('favicon.png'),
                    'canonical_url'      => url(''),
                ]
            );
            $data = [
                'title' => 'Rating',
                'transaction' => $transaction['result'],
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Riwayat',
                            'link' => '/history'
                        ],
                        3 => [
                            'title' => 'Rating',
                            'link' => ''
                        ]
                    ]
                ]
            ];
            return view('rating::index', compact('data'));
        }
        return abort(404);
    }

    public function create(Request $request)
    { 
        $create = MyHelper::post('user-rating/transaction/create', [
            'id' => $request->transaction,
            'id_product' => $request->id_product,
            'rating_value' => $request->rating,
            'suggestion' => $request->suggestion,
            'option_question' => 'Bagaimana menurutmu produk ini?',
            'option_value' => $request->option_value,
        ]);

        dd($create);
    }
}
