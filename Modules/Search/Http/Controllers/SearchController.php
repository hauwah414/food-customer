<?php

namespace Modules\Search\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class SearchController extends Controller
{
    use MetaTagTraits;

    public function index(Request $request)
    {
        $request = [
            'page' => '1',
            'search_key' => session('search')['key'] ??  '',
            'min_value' => session('search')['min_value'],
            'max_value' => session('search')['max_value'],
            'longitude' => session('search')['longitude'] ?? '',
            'latitude' => session('search')['latitude'] ?? '',
        ];

        $search = MyHelper::post('search', $request);
        $this->metaTagLoad(
            [
                'title'     => 'Search',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );

        if ($search['status'] == 'success') {
            $data = [
                'search' => $search['result'],
                'title' => 'Search',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Search',
                            'link' => '/search'
                        ],
                    ],
                ]
            ];
            return view('search::index', compact('data'));
        } else {
            $data = [
                'title' => 'Search',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Search',
                            'link' => '/search'
                        ],
                    ],
                ]
            ];
            return view('search::index', compact('data'));
        }
    }


    public function pagination(Request $request)
    {

        $search = [
            'page' => $request->id_page ?? '1', 
            'key' => $request->key,
            'min_value' => $request->min_value,
            'max_value' => $request->max_value,
            'longitude' =>  $request->longitude,
            'latitude' =>  $request->latitude
        ];

        session(['search' => $search]);

        $request = [
            'page' => $request->id_page ?? '1',
            'search_key' => $request->key ?? '',
            'min_value' =>  $request->min_value,
            'max_value' =>  $request->max_value,
            'longitude' => $request->longitude ?? '',
            'latitude' => $request->latitude ?? '',
        ]; 

        $search = MyHelper::post('search', $request);

        if ($search['status'] == 'success') {
            $data['search'] = $search['result'];
            return view('search::component.search_result', compact('data'));
        }
    } 
}
