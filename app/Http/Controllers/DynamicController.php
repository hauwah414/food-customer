<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\FlareClient\View;
use App\Lib\MyHelper;
use Butschster\Head\Facades\Meta;
use App\Http\Traits\MetaTagTraits;

class DynamicController extends Controller
{

    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function faq()
    {
        $this->metaTagLoad(
            [
                'title'     => 'FAQ',
                'alt_title'  => 'ITS FOOD',
                'description'   => '',
                'keywords'      => '',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $faq = MyHelper::get('setting/faq');

        if ($faq['status'] == 'success') {
            $data = [
                'title' => 'FAQ',
                'faq' => $faq['result'],
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/dashboard'
                        ],
                        2 => [
                            'title' => 'FAQ',
                            'link' => ''
                        ],
                    ]
                ]
            ];
            return view('pages.faq', compact('data'));
        }
        return abort('404');
    }

    public function contact()
    {
        $this->metaTagLoad(
            [
                'title'     => 'Contact',
                'alt_title'  => 'ITS FOOD',
                'description'   => '',
                'keywords'      => '',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );
        $contact = MyHelper::get('contact-us/list-subject');

        if ($contact['status'] == 'success') {
            $data = [
                'title' => 'Contact',
                'contact' => $contact['result'],
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/dashboard'
                        ],
                        2 => [
                            'title' => 'Contact',
                            'link' => ''
                        ],
                    ]
                ]
            ];
            return view('pages.contact', compact('data'));
        }
        return abort('404');
    }

    public function cs(Request $request)
    {
        $cs = MyHelper::post('cs', []);
        if ($cs['status'] == 'success') {

            $data['otlet'] = $cs['result'];

            return response()->json([
                'success' => true,
                'message' => 'Sucess',
                'data'    => $cs['result']
            ]);
        }
    }
}
