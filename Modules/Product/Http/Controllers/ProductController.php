<?php

namespace Modules\Product\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Traits\MetaTagTraits;

class ProductController extends Controller
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
                'title'     => 'Produk',
                'alt_title'  => 'ITS FOOD',
                'description'   => '',
                'keywords'      => '',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $data = [
            'title' => 'Produk',
            'breadcrumb' => [
                'items' => [
                    1 => [
                        'title' => 'Home',
                        'link' => '/'
                    ],
                    2 => [
                        'title' => 'Produk',
                        'link' => ''
                    ],
                ]
            ]
        ];
        return view('product::index', compact('data'));
    }

    public function getProducts(Request $request)
    {
        $form = [
            'pagination' => 1,
            'pagination_total_row' => 8,
            'page' => $request->id_page ?? '1',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];
        if (session('access_token')) {
            $products = MyHelper::post('product/list', $form);
        } else {
            $products = MyHelper::post('v2/product/list', $form);
        }

        if ($products['status'] == 'success') {
            $data['products'] = $products['result'];
            return view('product::components.products_result', compact('data'));
        }
    }

    public function show($id)
    {
        $id = base64_decode($id);
        $form = [
            'id_product' => $id,
        ];

        if (session('access_token')) {
            $product = MyHelper::post('product/detail', $form);
        } else {
            $product = MyHelper::post('v2/product/detail', $form);
        }

        if ($product['status'] == 'success') {

            $this->metaTagLoad(
                [
                    'title'     => $product['result']['product_name'],
                    'alt_title'  => 'ITS FOOD',
                    'description'   => $product['result']['product_description'],
                    'keywords'      => 'ITS FOOD' . ' ' . $product['result']['product_name'],
                    'featured_image' => asset('favicon.png'),
                    'canonical_url'      => url(''),
                ]
            );

            $data = [
                'product' => $product['result'],
                'title' => 'Detail Produk',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Produk',
                            'link' => '/product'
                        ],
                        3 => [
                            'title' => $product['result']['product_name'],
                            'link' => ''
                        ]
                    ],
                ]
            ]; 
            return view('product::show', compact('data'));
        }
        return abort(404);
    }
}
