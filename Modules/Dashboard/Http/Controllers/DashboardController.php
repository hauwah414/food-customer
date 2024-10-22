<?php

namespace Modules\Dashboard\Http\Controllers;

use app\Lib\MyHelper;
use Illuminate\Routing\Controller;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function index()
    {

        if (session('access_token')) {
            $newest = MyHelper::get('product/newest');
            $best = MyHelper::get('product/best-seller');
        } else {
            $newest = MyHelper::get('v2/product/newest');
            $best = MyHelper::get('v2/product/best-seller');
        }
        $banner = MyHelper::get('home/banner'); 
        $background = MyHelper::get('home/background');

        if (($newest['status'] == 'success') && ($best['status'] == 'success') && ($banner['status'] == 'success')
            && ($background['status'] == 'success')
        ) {
            $this->metaTagLoad(
                [
                    'title'     => 'Dashboard',
                    'alt_title'  => 'ITS FOOD',
                    'featured_image' => asset('favicon.png'),
                    'canonical_url'      => url(''),
                ]
            );

            $data = [
                'newest' => $newest['result'],
                'best' => $best['result'],
                'banner' => $banner['result'],
                'background' => $background['result']
            ];
            return view('dashboard::index', compact('data'));
        }

        return abort(404);
    }

    public function ProductsRecommend(Request $request)
    {
        $form = [
            'pagination' => 1,
            'pagination_total_row' => 4,
            'page' => 1,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];
        if (session('access_token')) {
            $recomend = MyHelper::post('product/recommendation', $form);
        } else {
            $recomend = MyHelper::post('v2/product/recommendation', $form);
        }

        if ($recomend['status'] == 'success') {

            $data['recomend'] = $recomend['result'];
            return view('dashboard::components.recommendation-result', compact('data'));

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil diambil!',
                'data'    => $recomend['result']
            ]);
        }
    }

    public function productsNearest(Request $request)
    {
        $form = [
            'pagination' => 1,
            'pagination_total_row' => 4,
            'page' => 1,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];
        if (session('access_token')) {
            $nearest = MyHelper::post('product/list', $form);
        } else {
            $nearest = MyHelper::post('v2/product/list', $form);
        }

        if ($nearest['status'] == 'success') {

            $data['nearest'] = $nearest['result'];

            return view('dashboard::components.products-result', compact('data'));

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil diambil!',
                'data'    => $nearest
            ]);
        }
    }

    public function outletNearest(Request $request)
    {
        $form = [
            'pagination' => 1,
            'pagination_total_row' => 4,
            'page' => 1,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];
        if (session('access_token')) {
            $outlet = MyHelper::post('outlet/nearby', $form);
        } else {
            $outlet = MyHelper::post('v2/outlet/nearby', $form);
        }
        if ($outlet['status'] == 'success') {

            $data['otlet'] = $outlet['result'];

            return view('dashboard::components.outlet-result', compact('data'));

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil diambil!',
                'data'    => $outlet['result']
            ]);
        }
    }
    public function search(Request $request)
    {
        $search = [
            'key' => $request->key,
            'min_value' => $request->min_value,
            'max_value' => $request->max_value,
            'longitude' =>  $request->longitude,
            'latitude' =>  $request->latitude
        ];
        
        session(['search' => $search]);

        return response()->json([
            'success' => true,
            'data'    => $search
        ]);
    }
}
