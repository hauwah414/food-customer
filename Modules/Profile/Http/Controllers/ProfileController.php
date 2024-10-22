<?php

namespace Modules\Profile\Http\Controllers;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\MetaTagTraits;

class ProfileController extends Controller
{
    use MetaTagTraits;

    public function __construct()
    {
        $this->middleware('prevent-back-history');
    }

    public function index()
    {

        $profile = MyHelper::get('users/profile/detail');
        $province = MyHelper::get('province/list');

        if ($profile['status'] == 'success' && $province['status'] == 'success') {
            session(['detail_user' => $profile['result']]);

            $this->metaTagLoad(
                [
                    'title'     => 'Profile',
                    'alt_title'  => 'ITS FOOD',
                    'description'   => '',
                    'keywords'      => '',
                    'featured_image' => asset('favicon.png'),
                    'canonical_url'      => url(''),
                ]
            );

            $data = [
                'page_title' => 'Profile',
                'profile' => $profile['result'],
                'province' => $province['result'],
                'title' => 'Profil',
                'breadcrumb' => [
                    'items' => [
                        1 => [
                            'title' => 'Home',
                            'link' => '/'
                        ],
                        2 => [
                            'title' => 'Profile',
                            'link' => ''
                        ],
                    ],
                ]
            ];
            return view('profile::index', compact('data'));
        }
        return abort(404);
    }

    public function updateInfo(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:155',
                'email'     => 'required|email:rfc,dns',
            ],
            [
                'name.required' => 'User name harus diisi',
                'name.string' => 'User name tidak diizinkan',
                'name.max' => 'User name maksimal 155',
                'gender.required' => 'Jenis kelamin harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email anda tidak sesuai',
            ]
        );
        $form = [
            'name' => $request->name,
            'email'  => $request->email,
            'gender'  => $request->gender,
        ];
        $updateInfo = MyHelper::post('users/profile/update-info', $form);
        if ($updateInfo['status'] == 'success') {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'success' => 'Info profile anda berhasil diperbarui!'
                ]);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                'error' => 'Maaf anda gagal memperbarui info profil!'
            ]);
    }

    public function updateAddress(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'birth_date' => 'required',
                'id_province' => 'required',
                'id_city' => 'required',
                'id_district' => 'required',
                'id_subdistrict' => 'required',
                'address_postal_code' => 'required|numeric|digits:5',
                'address' => 'required',
                'gender' => 'required',
            ],
            [
                'birth_date.required' => 'Tanggal lahir harus diisi',
                'id_province.required' => 'Kota harus diisi',
                'id_city.required' => 'Kota harus diisi',
                'id_district.required' => 'Daerah harus disi',
                'id_subdistrict.required' => 'Kecamatan harus diisi',
                'address_postal_code.required' => 'Kode Pos harus diisi',
                'address.required' => 'Alamat harus diisi',
                'gender.email' => 'Email anda tidak sesuai',
            ]
        );

        $form = [
            'birth_date' => $request->birth_date,
            'id_subdistrict' => $request->id_subdistrict,
            'gender'  => $request->gender,
            'address_postal_code'  => $request->address_postal_code,
            'address'  => $request->address,
        ];

        $updateInfo = MyHelper::post('users/profile/update-personal', $form); 
        if ($updateInfo['status'] == 'success') {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'success' => 'Personal profile anda berhasil diperbarui!'
                ]);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                'error' => 'Maaf anda gagal memperbarui Personal Profil!'
            ]);
    }

    public function updatePhoto(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'photo' => 'required|image|mimes:jpeg,png,jpg,JPG,JPEG,PNG|max:1048',
            ]
        );
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Maaf anda gagal memperbarui photo!
                    Pastikan ukuran photo dibawah 1MB'
                ]);
        }

        $photo = MyHelper::encodeImage($request->photo); 

        $form = [
            'photo' => $photo,
        ];

        $updatePhoto = MyHelper::post('users/profile/update-photo', $form);
        if (isset($updatePhoto) && ($updatePhoto['status'] == 'success')) {
            $request->session()->forget('detail_user');
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'success' => 'Photo anda berhasil diperbarui!'
                ]);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with([
                'error' => 'Maaf anda gagal memperbarui photo!'
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
}
