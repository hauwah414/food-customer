<?php

namespace Modules\Notification\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Traits\MetaTagTraits;
use App\Lib\MyHelper;

class NotificationController extends Controller
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
                'title'     => 'Notifikasi',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $form = [
            'pagination' => 1,
            'pagination_total_row' => 10,
            'page'     => 1,
        ];

        $notification = MyHelper::post('notification/list', $form);

        if ($notification['status'] == 'success') {
            $data = [
                'notification' => $notification['result'],
                'title' => 'Notifikasi',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Notifikasi',
                            'link' => '/notification'
                        ],
                    ],
                ]
            ];
            return view('notification::index', compact('data'));
        }
        return abort(404);
    }

    public function pagination($page)
    {
        $this->metaTagLoad(
            [
                'title'     => 'Notifikasi - Page ' . $page,
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $form = [
            'pagination' => 1,
            'pagination_total_row' => 10,
            'page'     => $page
        ];

        $notification = MyHelper::post('notification/list', $form);

        if ($notification['status'] == 'success') {

            $data = [
                'notification' => $notification['result'],
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Notifikasi',
                            'link' => '/notification'
                        ],
                    ],
                ]
            ];
 
            return view('notification::index', compact('data'));
        }
        return abort(404);
    }

    public function show($id)
    {
        $id = base64_decode($id);
        $this->metaTagLoad(
            [
                'title'     => 'Notifikasi',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );

        $detail = MyHelper::get('notification/detail/' . $id);

        if ($detail['status'] == 'success') {
            $data = [
                'notification' => $detail['result'],
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Notifikasi',
                            'link' => '/notification'
                        ],
                        3 => [
                            'title' => 'Detail',
                            'link' => ''
                        ]
                    ],
                ]
            ];
            return view('notification::show', compact('data'));
        }
        return abort(404);
    }
    public function count(Request $request)
    {
        $count = MyHelper::post('notification/count', []);

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
}
