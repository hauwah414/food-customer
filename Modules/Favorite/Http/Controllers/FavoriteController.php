<?php

namespace Modules\Favorite\Http\Controllers;

use app\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator; 
use App\Http\Traits\MetaTagTraits;

class FavoriteController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        $form = [
            'pagination' => 1,
            'pagination_total_row' => 8,
            'page'     => 1,
        ];

        $favorite = MyHelper::post('favorite/list', $form);
        if ($favorite['status'] == 'success') {

            $this->metaTagLoad(
                [
                    'title'     => 'Daftar Favorite',
                    'alt_title'  => 'ITS FOOD', 
                    'featured_image' => asset('favicon.png'),
                    'canonical_url'      => url(''),
                ]
            );

            $data = [
                'favorite' => $favorite['result'],
                'title' => 'Favorite',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Favorite',
                            'link' => ''
                        ],
                    ]
                ]
            ];

            return view('favorite::index', compact('data'));
        }
        return abort(404);
    }

    public function pagination($page)
    {

        $form = [
            'pagination' => 1,
            'pagination_total_row' => 8,
            'page'     => $page,
        ];

        $favorite = MyHelper::post('favorite/list', $form);
        if ($favorite['status'] == 'success') {

            $this->metaTagLoad(
                [
                    'title'     => 'Daftar Favorite - Page ' . $page,
                    'alt_title'  => 'ITS FOOD',
                    'featured_image' => asset('favicon.png'),
                    'canonical_url'      => url(''),
                ]
            );

            $data = [
                'favorite' => $favorite['result'],
            ];

            return view('favorite::index', compact('data'));
        }
        return abort(404);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $form = [
            'id_product' => $request->product_id
        ];

        $create = MyHelper::post('favorite/create', $form);

        $form = [
            'pagination' => 1,
            'pagination_total_row' => 8,
            'page'     => 1,
        ];

        $total_favorite = MyHelper::post('favorite/list', $form);

        if ($create['status'] == 'success' && $total_favorite['status'] == 'success') {

            $request->session()->forget('total_favorite');
            session(['total_favorite' => $total_favorite['result']['total']]);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil ditambahkan!',
                'data'    => $create
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $form = [
            'id_product' => $request->product_id
        ];

        $destroy = MyHelper::post('favorite/delete', $form);

        $form = [
            'pagination' => 1,
            'pagination_total_row' => 8,
            'page'     => 1,
        ];

        $total_favorite = MyHelper::post('favorite/list', $form);

        if ($destroy['status'] == 'success' && $total_favorite['status'] == 'success') {

            $request->session()->forget('total_favorite');
            session(['total_favorite' => $total_favorite['result']['total']]);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil dihapus!',
                'data'    => $destroy
            ]);
        }
    }
}
