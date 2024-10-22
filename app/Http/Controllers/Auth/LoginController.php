<?php

namespace App\Http\Controllers\Auth;

use App\Lib\MyHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function login()
    {
        $ses = session('access_token');
        if (empty($ses)) {
            return view('pages.auth.login');
        } else {
            return redirect('');
        }
    }

    public function loginCheck(Request $request, $data = null)
    {
        $response = Http::get('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request['g-recaptcha-response'],
        ])->json();
        
        if (($response['success'] == 'true') && ($response['score'] > .3)) {
            $form = [
                'username'     => $data['username'] ?? $request->username,
                'password'  => $data['password'] ?? $request->password
            ];

            $post_login = MyHelper::postLogin($form);
            if (!($post_login['access_token'] ?? false) || isset($post_login['error'])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        Alert::error('Gagal', 'Nomor telepon atau password anda salah!')
                    ]);
            } elseif (isset($post_login['status']) && $post_login['status'] == "fail") {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        Alert::error('Gagal', 'Nomor telepon atau password anda salah!')
                    ]);
            } else {
                return $this->successLogin($post_login);
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function successLogin($login)
    {

        session([
            'access_token' => 'Bearer ' . $login['access_token'],
        ]);

        $profile = MyHelper::get('users/profile/detail');

        $totalFavorite = [
            "pagination" => 1,
            "pagination_total_row" => 10
        ];

        $favorite = MyHelper::post('favorite/list', $totalFavorite);

        if ($profile['status'] == 'success' && $favorite['status'] == 'success') {

            session(['detail_user' => $profile['result']]);

            session(['total_favorite' => $favorite['result']['total']]);

            return redirect('')
                ->withInput()
                ->with([
                    Alert::success('Selamat Datang', $profile['result']['info']['name'])
                ]);
        }
        return abort(404);
    }


    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
