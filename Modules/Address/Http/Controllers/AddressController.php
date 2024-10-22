<?php

namespace Modules\Address\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Butschster\Head\Facades\Meta;
use App\Http\Traits\MetaTagTraits;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;


class AddressController extends Controller
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
                'title'     => 'Daftar Alamat',
                'alt_title'  => 'ITS FOOD',
                'featured_image' => asset('favicon.png'),
                'canonical_url'      => url(''),
            ]
        );

        $address = MyHelper::post('transaction/address', []);
        // return $address;
        // if ($address['status'] == 'success') {
            $data = [
                'title' => 'Daftar Alamat',
            'address' => $address['result'] ?? [],
            'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Daftar Alamat',
                            'link' => '/address'
                        ],
                    ]
                ],
            ];
            return view('address::pages.index', compact('data'));
        // }
        // return abort(404);
    }

    public function create()
    {
        $province = MyHelper::get('province/list');

        if ($province['status'] == 'success') {

            $this->metaTagLoad(
                [
                    'title'     => 'Tambah Alamat',
                    'alt_title'  => 'ITS FOOD',
                    'featured_image' => asset('favicon.png'),
                    'canonical_url'      => url(''),
                ]
            );

            $data = [
                'title' => 'Tambah Alamat',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Daftar Alamat',
                            'link' => '/address'
                        ],
                        3 => [
                            'title' => 'Tambah',
                            'link' => ''
                        ],
                    ]
                ],
                'province' => $province['result']
            ];
            return view('address::pages.create', compact('data'));
        }

        return abort(404);
    }

    public function show($id_user_address)
    {
        $province = MyHelper::get('province/list');

        $detail = MyHelper::post('transaction/address/detail', ['id_user_address' => $id_user_address]);

        if ($province['status'] == 'success' && $detail['status'] == 'success') {

            $city = MyHelper::POST('city/list', ['id_province' => $detail['result']['id_province']]);
            $district = MyHelper::POST('district/list', ['id_city' => $detail['result']['id_city']]);
            $subdistrict = MyHelper::POST('subdistrict/list', ['id_district' => $detail['result']['id_district']]);

            if ($city['status'] == 'success' && $district['status'] == 'success' && $subdistrict['status'] == 'success') {
                $this->metaTagLoad(
                    [
                        'title'     => 'Ubah Alamat',
                        'alt_title'  => 'ITS FOOD',
                        'featured_image' => asset('favicon.png'),
                        'canonical_url'      => url(''),
                    ]
                );

                $data = [
                    'title' => 'Ubah Alamat',
                    'breadcrumb' => [
                        'items' => [
                            1 => [
                                'title' => 'Alamat',
                                'link' => '/history'
                            ],
                            2 => [
                                'title' => 'Ubah',
                                'link' => ''
                            ],
                        ]
                    ],
                    'province' => $province['result'],
                    'city' => $city['result'],
                    'district' => $district['result'],
                    'subdistrict' => $subdistrict['result'],
                    'detail' => $detail['result']
                ];
                return view('address::pages.update', compact('data'));
            }
            return abort(404);
        }
        return abort(404);
    }


    public function update(Request $request, $id_user_address)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'receiver_name' => 'required',
                'receiver_phone' => 'required',
                'receiver_email'     => 'required|email:rfc,dns',
                'id_province' => 'required',
                'id_city' => 'required',
                'id_district' => 'required',
                'id_subdistrict' => 'required',
                'address'  => 'required',
                'location_name'  => 'required',
                'latitude'  => 'required',
                'longitude'  => 'required',
                'postal_code'  => 'required|numeric|digits:5',
            ], 
            [
                'receiver_name.required' => 'Nama harus diisi',
                'receiver_phone.required' => 'Telephone harus diisi',
                'receiver_email.required' => 'Email harus diisi',
                'receiver_email.email' => 'Email anda tidak sesuai',
                'id_province.required' => 'Provinsi harus diisi',
                'id_city.required' => 'Kota harus diisi',
                'id_district.required' => 'Daerah harus disi',
                'id_subdistrict.required' => 'Kecamatan harus diisi',
                'address.required' => 'Alamat harus diisi',
                'location_name.required' => 'Lokasi harus diisi',
                'postal_code.required' => 'Kode Pos harus diisi',
            ]
        );

        $receiver_phone = str_replace(array(" ", "_"), "", $request->receiver_phone);

        if (strlen($receiver_phone) <= 10) {
            $validator->errors()->add('receiver_phone', 'Nomor telphone minimal 12 angka');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $form = [
            'id_user_address' => $id_user_address,
            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $receiver_phone,
            'receiver_email' =>  $request->receiver_email,
            'id_city'  => $request->id_city,
            'id_subdistrict'  => $request->id_subdistrict,
            'address'  => $request->address,
            'postal_code'  => $request->postal_code,
            'latitude'  => $request->latitude,
            'longitude'  => $request->longitude,
            'main_address'  => 0,
        ];
        $post = MyHelper::post('transaction/address/update', $form);

        if ($post['status'] == 'success') {
            return redirect('address')
                ->withInput()
                ->with([
                    'success' => 'Alamat berhasil diubah!'
                ]);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                'error' => 'Maaf alamat gagal untuk diperbarui!'
            ]);
    }

    public function ajaxCities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_province'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $Post = MyHelper::post('city/list', [
            'id_province' => $request->id_province
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil ditampilkan!',
            'data'    => $Post
        ]);
    }

    public function ajaxDistricts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_city'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $Post = MyHelper::post('district/list', [
            'id_city' => $request->id_city
        ]);
        if ($Post['status'] == 'success') {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil ditampilkan!',
                'data'    => $Post
            ]);
        }
    }
    public function ajaxSubDistric(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_district'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $Post = MyHelper::post('subdistrict/list', [
            'id_district' => $request->id_district
        ]);
        if ($Post['status'] == 'success') {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil ditampilkan!',
                'data'    => $Post
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'receiver_name' => 'required',
                'receiver_phone' => 'required',
                'receiver_email'     => 'required|email:rfc,dns',
                'id_province' => 'required',
                'id_city' => 'required',
                'id_district' => 'required',
                'id_subdistrict' => 'required',
                'address'  => 'required',
                'location_name'  => 'required',
                'latitude'  => 'required',
                'longitude'  => 'required',
                'postal_code'  => 'required|numeric|digits:5',
            ],
            [
                'receiver_name.required' => 'Nama harus diisi',
                'receiver_phone.required' => 'Telephone harus diisi',
                'receiver_email.required' => 'Email harus diisi',
                'receiver_email.email' => 'Email anda tidak sesuai',
                'id_province.required' => 'Provinsi harus diisi',
                'id_city.required' => 'Kota harus diisi',
                'id_district.required' => 'Daerah harus disi',
                'id_subdistrict.required' => 'Kecamatan harus diisi',
                'address.required' => 'Alamat harus diisi',
                'location_name.required' => 'Lokasi harus diisi',
                'postal_code.required' => 'Kode Pos harus diisi',
            ]
        );

        $receiver_phone = str_replace(array(" ", "_"), "", $request->receiver_phone);

        if (strlen($receiver_phone) <= 10) {
            $validator->errors()->add('receiver_phone', 'Nomor telphone minimal 12 angka');
            return Redirect::back()->withErrors($validator)->withInput();
        }


        $form = [
            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $receiver_phone,
            'receiver_email' =>  $request->receiver_email,
            'id_city'  => $request->id_city,
            'id_subdistrict'  => $request->id_subdistrict,
            'address'  => $request->address,
            'latitude'  => $request->latitude,
            'longitude'  => $request->longitude,
            'postal_code'  => $request->postal_code,
            'main_address'  => 0,
        ];
        $post = MyHelper::post('transaction/address/add', $form);
        
        if ($post['status'] == 'success') {
            return redirect('address')
                ->withInput()
                ->with([
                    'success' => 'Alamat baru ditambahkan!'
                ]);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                'error' => 'Maaf alamat baru gagal ditambahan, coba ulangi lagi!'
            ]);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user_address'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $form = [
            'id_user_address' => $request->id_user_address
        ];

        $destroy = MyHelper::post('transaction/address/delete', $form);

        if ($destroy['status'] == 'success') {

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil dihapus!',
                'data'    => $destroy
            ]);
        }
    }

    public function mainAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user_address'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $form = [
            'id_user_address' => $request->id_user_address
        ];

        $post = MyHelper::post('transaction/address/mainAddress', $form);

        if ($post['status'] == 'success') {

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil diubah!',
                'data'    => $post
            ]);
        }
    }
}
