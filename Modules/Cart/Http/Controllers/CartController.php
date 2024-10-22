<?php

namespace Modules\Cart\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }
    public function index()
    {
        session()->forget('cart');

        $this->metaTagLoad(
            [
                'title'     => 'Keranjang',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );

        $list = MyHelper::post('transaction/cart/list', []);
        if ($list['status'] == 'success') {
            $cart = MyHelper::post('transaction/cart', $list['result']);

            if ($cart['status'] == 'success') {
                $data = [
                    'cart' => $cart['result'],
                    'title' => 'Keranjang',
                    'breadcrumb' => [
                        'items' => [
                            1 => [
                                'title' => 'Home',
                                'link' => '/'
                            ],
                            2 => [
                                'title' => 'Keranjang',
                                'link' => ''
                            ],
                        ]
                    ],
                ];
                return view('cart::index', compact('data'));
            }
        }
        if ($list['status'] == 'fail') {
            $data = [
                'title' => 'Keranjang',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Keranjang',
                            'link' => ''
                        ],
                    ]
                ],
            ];
            return view('cart::index', compact('data'));
        }

        return abort(404);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_product'     => 'required',
            'qty'     => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->id_product_serving_method != null) {

            $exploded = explode(',', $request->items);

            $items = array_map(function ($item) {
                return trim($item);
            }, $exploded);

            $form = [
                'id_product' => $request->id_product,
                'qty' => $request->qty,
                'custom' => 'box',
                'serving_method' => [
                    'id_product_serving_method' => $request->id_product_serving_method
                ],
                'item' => $items,
            ];
            $create = MyHelper::post('transaction/cart/create', $form);

            if (session('cart') == null) {
                $list = MyHelper::post('transaction/cart/list', []);
                $cart = MyHelper::post('transaction/cart', $list['result']);
            } else {
                $targetId = $request->id_product;
                $newQty = $request->qty;
                $array = session('cart');

                foreach ($array as &$data) {
                    foreach ($data['items'] as &$item) {
                        if ($item['id_product'] == $targetId) {
                            $item['qty'] = $newQty;
                        }
                    }
                }
                $cart = MyHelper::post('transaction/cart', $array);
            }
            if ($create['status'] == 'success') {
                $data = $cart['result'];
                return view('cart::components.table-total', compact('data'));

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil!',
                    'data'    => $cart
                ]);
            }
        } else {
            $form = [
                'id_product' => $request->id_product,
                'qty' => $request->qty,
                'custom' => 'product'
            ];

            $create = MyHelper::post('transaction/cart/create', $form);

            if (session('cart') == null) {
                $list = MyHelper::post('transaction/cart/list', []);
                $cart = MyHelper::post('transaction/cart', $list['result']);
            } else {
                $targetId = $request->id_product;
                $newQty = $request->qty;
                $array = session('cart');

                foreach ($array as &$data) {
                    foreach ($data['items'] as &$item) {
                        if ($item['id_product'] == $targetId) {
                            $item['qty'] = $newQty;
                        }
                    }
                }
                $cart = MyHelper::post('transaction/cart', $array);
            }

            if ($create['status'] == 'success') {
                $data = $cart['result'];
                return view('cart::components.table-total', compact('data'));

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil!',
                    'data'    => $cart['result']
                ]);
            }
        }
    }

    public function checkbox(Request $request)
    {

        if ($request->items) {
            $list = MyHelper::post('transaction/cart/list', []);

            if ($list['status'] == 'success') {
                $items = $list['result'];
                $targetItems = $request->items;
                $filteredArray = [];

                foreach ($items as $data) {
                    $filteredItems = [];

                    foreach ($data['items'] as $item) {
                        if (in_array($item['id_product'], $targetItems)) {
                            $filteredItems[] = $item;
                        }
                    }
                    if (!empty($filteredItems)) {
                        $filteredArray[] = [
                            "id_outlet" => $data['id_outlet'],
                            "items" => $filteredItems
                        ];
                    }
                }

                $cart = MyHelper::post('transaction/cart', $filteredArray);

                if ($cart['status'] == 'success') {

                    session(['cart' => $filteredArray]);

                    $data = $cart['result'];
                    return view('cart::components.table-total', compact('data'));

                    return response()->json([
                        'success' => true,
                        'message' => 'Berhasil!',
                        'data'    => $data
                    ]);
                }
            }
        }
        return response()->json(['message' => 'gagal'], 422);
    }

    public function addOrder(Request $request)
    {
        if ($request->id_product_serving_method) {
            $validator = Validator::make($request->all(), [
                'id_product'     => 'required',
                'quality'     => 'required',
                'outlet'     => 'required',
                'custom'     => 'required',
                'id_product_serving_method'     => 'required',
                'item_product'     => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $form = [
                "id_product" => $request->id_product,
                "qty" => $request->quality,
                "custom" => "box",
                "serving_method" =>  [
                    "id_product_serving_method" => $request->id_product_serving_method['0']
                ],
                "item" => explode(", ", $request->item_product)
            ];
            $product = MyHelper::post('transaction/cart/create', $form);
        } else {
            $validator = Validator::make($request->all(), [
                'id_product'     => 'required',
                'quality'     => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $form = [
                'id_product' => $request->id_product,
                'qty' => $request->quality,
                'custom' => 'product'
            ];

            $product = MyHelper::post('transaction/cart/create', $form);

            if ($product['status'] == 'success') {

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil!',
                    'data'    => $product
                ]);
            }
        }
    }

    public function count()
    {
        $count = MyHelper::post('transaction/cart/count', []);

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


    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_product'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $form = [
            'id_product' => $request->id_product
        ];

        $destroy = MyHelper::post('transaction/cart/delete', $form);

        if ($destroy['status'] == 'success') {

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil dihapus!',
                'data'    => $destroy
            ]);
        }
    }


    public function destroyMultiple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $list = MyHelper::post('transaction/cart/list', []);

        if ($list['status'] == 'success') {

            $idCarts = [];

            foreach ($list['result'] as $data) {
                foreach ($data['items'] as $item) {
                    if (in_array($item['id_product'], $request->items)) {
                        $idCarts[] = $item['id_cart'];
                    }
                }
            }

            $form = [
                'id_cart' => $idCarts
            ];

            $destroy = MyHelper::post('transaction/cart/delete-multiple', $form);
            if ($destroy['status'] == 'success') {

                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil dihapus!',
                    'data'    => $destroy
                ]);
            }
        }
    }
}
