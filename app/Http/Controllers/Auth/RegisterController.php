<?php

namespace App\Http\Controllers\Auth;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use App\Http\Traits\MetaTagTraits;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use MetaTagTraits;

    public function signup()
    {
        if (session('detail_user') == null) {

            $client_token = MyHelper::postLoginClient();

            $token = $client_token['access_token'];
            session(['access_token_client' => 'Bearer ' . $token]);
            $department = MyHelper::get('users/department');

            if (isset($department) && ($department['status'] == 'success')) {
                $this->metaTagLoad(
                    [
                        'title'     => 'Daftar',
                        'alt_title'  => 'ITS FOOD',
                        'featured_image' => asset('favicon.png'),
                        'canonical_url'      => url(''),
                    ]
                );
                $data = [
                    'page_title' => 'Daftar',
                    'department' => $department['result']
                ];
            return view('pages.auth.register', compact('data'));
            } 
        } else {
            return redirect()
                ->back();
        }
    }

    public function signupPost(Request $request)
    {
        $response = Http::get('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request['g-recaptcha-response'],
        ])->json();

        if (($response['success'] == 'true') && ($response['score'] > .3)) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:155',
                    'phone_number' => 'required',
                    'birthday' => 'required',
                    'gender' => 'required',
                    'id_department' => 'required',
                    'email'     => 'required|email:rfc,dns',
                    'password'  => 'required|confirmed|min:6', 
                ],
                [
                    'name.required' => 'User name harus diisi',
                    'name.string' => 'User name tidak diizinkan',
                    'name.max' => 'User name maksimal 155',
                    'birthday.required' => 'Tanggal lahir harus diisi',
                    'gender.required' => 'Jenis kelamin harus diisi',
                    'id_department.required' => 'Department Harus diisi',
                    'phone_number.required' => 'Nomor telepon harus diisi',
                    'email.required' => 'Email harus diisi',
                    'email.email' => 'Email anda tidak sesuai',
                    'password.required' => 'Password harus diisi',
                    'password.confirmed' => 'Password Harus sama',
                    'password.min' => 'Password minimal 6 karakter',
                ]
            );

            $phone_number = str_replace(array(" ", "_"), "", $request->phone_number);

            if (strlen($phone_number) < 11) {
                $validator->errors()->add('phone_number', 'Nomor telphone minimal 11 angka');
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $form = [
                'name' => $request->name,
                'gender'  => $request->gender,
                'phone' => $phone_number,
                'email'  => $request->email,
                'password'  => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'birthday'     => $request->birthday,
                'id_department'  => $request->id_department,
            ];

            $client_token = MyHelper::postLoginClient();
            $token = $client_token['access_token'];

            session(['token' => 'Bearer ' . $token]);

            $register = MyHelper::postRegister('users/register', $form);

            if ($register['status'] == 'fail') {
                return redirect()
                    ->route('register')
                    ->withInput()
                    ->with([
                        Alert::error('Gagal', 'Email atau Nomor telephone anda sudah terdaftar!')
                    ]);
            }

            session()->flush();

            if ($register['status'] == 'success') {
                return redirect()
                    ->route('login')
                    ->withInput()
                    ->with([
                        Alert::success('Selamat', 'Akun anda berhasil dibuat!')
                    ]);
            }
        } else {
            return redirect()->route('register');
        }
    }
}
