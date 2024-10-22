<?php

namespace Modules\Outlet\Http\Controllers;

use app\Lib\MyHelper; 
use Illuminate\Routing\Controller;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // if (session('access_token')) {
        //     $outlet = MyHelper::get('outlet/list');
        // } else 
        // {
        // $outlet = MyHelper::get('v2/outlet/list');
        // }
        $form = [
            'page' => 1,
            'search_key' => "",
            'terbaru' => '1',
            "abjad" => "1"
        ];
        $outlet = MyHelper::post('search/outlet', $form); 

        if ($outlet['status'] == 'success') {
            $this->metaTagLoad(
                [
                    'title'     => 'Vendor',
                    'alt_title'  => 'ITS FOOD',
                    'featured_image' => asset('favicon.png'),
                    'canonical_url'      => url(''),
                ]
            );

            $data = [
                'outlet' => $outlet['result'],
                'title' => 'Vendor',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Vendor',
                            'link' => ''
                        ],
                    ]
                ]
            ]; 
            return view('outlet::index', compact('data'));
        }

        return abort(404);
    }

    public function showOutlet($slug)
    {
        $outlet = MyHelper::post('v2/outlet/detail', ['outlet_code' => $slug]);

        if ($outlet['status'] == 'success') {
            $this->metaTagLoad(
                [
                    'title'     => 'Vendor - '  . $outlet['result']['outlet_name'] ?? '',
                    'alt_title'  => 'ITS FOOD',
                    'featured_image' => asset('favicon.png'),
                    'canonical_url'      => url(''),
                ]
            );

            $data = [
                'outlet' => $outlet['result'],
                'title' => $outlet['result']['outlet_name'] ?? '',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Vendor',
                            'link' => '/outlet'
                        ],
                        3 => [
                            'title' => $outlet['result']['outlet_name'] ?? '',
                            'link' => ''
                        ],
                    ]
                ]
            ];
            return view('outlet::show', compact('data'));
        }
        return abort(404);
    }

    public function search(Request $request)
    { 
        $form = [
            'page' => $request->page,
            'search_key' => $request->search_key,
            'terbaru' => $request->terbaru,
            "abjad" => "1"
        ];
        $data = MyHelper::post('search/outlet', $form);
        if ($data['status'] == 'success') {
            $data  = [
                'outlet' => $data['result']
            ];
            return view('outlet::components.outlet', compact('data'));
        } else {
            return response()->json([
                'error' => 'Unprocessable Entity',
                'message' => 'Gagal',
            ], 422);
        }
    }
}
