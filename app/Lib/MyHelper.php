<?php

namespace App\Lib;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PhpParser\Node\Expr\Cast\Bool_;

class MyHelper
{
    public static function encodeImage($image)
    {
        $size   = $image->getSize();
        $encoded = "";
        if ($size < 90000000) {
            $encoded = base64_encode(fread(fopen($image, "r"), filesize($image)));
        } else {
            return false;
        }

        return $encoded;
    }

    public static function convertDate($date)
    {
        $date = explode('/', $date);
        $date = $date[2] . '-' . $date[1] . '-' . $date[0];
        $date = date('Y-m-d', strtotime($date));
        return $date;
    }

    public static function convertDate2($date)
    {
        $date = explode('-', $date);
        $date = $date[2] . '-' . $date[1] . '-' . $date[0];
        $date = date('Y-m-d', strtotime($date));
        return $date;
    }

    public static function convertDateTime($date)
    {
        $date    = explode(' ', $date);
        $tanggal = explode("-", $date[0]);
        $tanggal = $tanggal[2] . '-' . $tanggal[1] . '-' . $tanggal[0];
        $tanggal = $tanggal . ' ' . $date[1];
        $date    = date('Y-m-d H:i:s', strtotime($tanggal));
        return $date;
    }

    public static function postLogin($request)
    {
        $api = env('APP_API_URL');
        $client = new Client();

        try {
            $response = $client->request('POST', $api . '/oauth/token', [
                'form_params' => [
                    'grant_type'    => 'password',
                    'client_id'     => env('PASSWORD_CREDENTIAL_ID'),
                    'client_secret' => env('PASSWORD_CREDENTIAL_SECRET'),
                    'username'      => $request['username'],
                    'password'      => $request['password'],
                    // 'provider'      => 'users'
                    'scope'         => 'apps',
                    // 'lang'          => session('locale')
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            try {
                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    return json_decode($response, true);
                } else {
                    return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
                }
            } catch (Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function postLoginClient()
    {
        $api = env('APP_API_URL');
        $client = new Client;

        try {
            $response = $client->request('POST', $api . '/oauth/token', [
                'form_params' => [
                    'grant_type'    => 'client_credentials',
                    'client_id'     => env('CLIENT_CREDENTIAL_ID'),
                    'client_secret' => env('CLIENT_CREDENTIAL_SECRET'),
                    'scope'          => 'apps',
                    'lang'          => session('locale')
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            try {
                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    return json_decode($response, true);
                } else {
                    return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
                }
            } catch (Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function postLoginSocial($post)
    {

        $api = env('APP_API_URL');
        $client = new Client;

        $ses = session('access_token')??session('access_token_client');;

        $content = array(
            'headers' => [
                'Authorization' => $ses,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'ip-address-view' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] :  '',
                'user-agent-view' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] :  '',
            ],
            'json' => (array) $post
        );

        try {
            $response = $client->post($api . '/auth/social', $content);
            if (!is_array(json_decode($response->getBody(), true)));
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            try {
                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    if (!is_array($response));
                    return json_decode($response, true);
                } else  return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            } catch (Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function getWithBearer($url, $bearer)
    {
        $api = env('APP_API_URL');
        $client = new Client;


        $content = array(
            'headers' => [
                'Authorization'   => $bearer,
                'Accept'          => 'application/json',
                'Content-Type'    => 'application/json',
                'ip-address-view' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] :  '',
                'user-agent-view' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] :  '',
            ]
        );

        try {
            $response =  $client->request('GET', $api . '/api/' . $url, $content);
            return json_decode($response->getBody(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            try {

                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    $error = json_decode($response, true);

                    if (!$error) {
                        return $e->getResponse()->getBody();
                    } else {
                        return $error;
                    }
                } else return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            } catch (Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function get($url, $post = null)
    {
        $api = env('APP_API_URL');
        $client = new Client;

        $ses = session('access_token')??session('access_token_client');

        $content = array(
            'headers' => [
                'Authorization'   => $ses,
                'Accept'          => 'application/json',
                'Content-Type'    => 'application/json',
                'ip-address-view' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] :  '',
                'user-agent-view' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] :  '',
            ],
            'json' => (array) $post
        );

        try {
            $response =  $client->request('GET', $api . '/api/' . $url, $content);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            try {

                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    $error = json_decode($response, true);

                    if (!$error) {
                        return $e->getResponse()->getBody();
                    } else {
                        return $error;
                    }
                } else return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            } catch (\Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function post($url, $post)
    {
        //dd($post);    
        $api = env('APP_API_URL');
        $client = new Client;

        $ses = session('access_token')??session('access_token_client');

        $content = array(
            'headers' => [
                'Authorization' => $ses,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'ip-address-view' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] :  '',
                'user-agent-view' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] :  '',
            ],
            'json' => (array) $post
        );

        try {
            $response = $client->post($api . '/api/' . $url, $content);
            if (!is_array(json_decode($response->getBody(), true)));
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            try {
                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    if (!is_array($response));
                    return json_decode($response, true);
                } else  return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            } catch (Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function postRegister($url, $post)
    {
        $api = env('APP_API_URL');
        $client = new Client;

        $ses = session('token');

        $content = array(
            'headers' => [
                'Authorization' => session()->get('token'),
                'Authorization' => $ses,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'ip-address-view' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] :  '',
                'user-agent-view' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] :  '',
            ],
            'json' => (array) $post
        );

        try {
            $response = $client->post($api . '/api/' . $url, $content);
            if (!is_array(json_decode($response->getBody(), true)));
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            try {
                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    if (!is_array($response));
                    return json_decode($response, true);
                } else  return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            } catch (Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }


    public static function postFile($url, $name_field, $path)
    {
        $api = env('APP_API_URL');
        $client = new Client();

        $ses = session('access_token');

        $content = array(
            'headers' => [
                'Authorization' => $ses,
                // 'Accept'        => 'application/json', 
                // 'Content-Type'  => 'application/json' 
            ],
            'multipart' => [
                [
                    'name'     => $name_field,
                    'contents' => fopen($path, 'r'),
                    // 'filename' => $name 
                ]
            ]
        );

        try {
            $response = $client->post($api . '/api/' . $url, $content);
            if (!is_array(json_decode($response->getBody(), true)));
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            try {
                //print_r($e);
                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    if (!is_array($response));
                    return json_decode($response, true);
                } else  return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            } catch (Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function postWithBearer($url, $post, $bearer)
    {
        $api = env('APP_API_URL');
        $client = new Client;

        $content = array(
            'headers' => [
                'Authorization' => $bearer,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'ip-address-view' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] :  '',
                'user-agent-view' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] :  '',
            ],
            'json' => (array) $post
        );

        try {
            $response = $client->post($api . '/api/' . $url, $content);
            // echo "a"; exit();
            if (!is_array(json_decode($response->getBody(), true)));
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            try {
                //print_r($e);
                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    if (!is_array($response));
                    return json_decode($response, true);
                } else  return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            } catch (Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function postBiasa($url, $post)
    {
        $api = env('APP_API_URL');
        $client = new Client;

        $content = array(
            'headers' => [
                'Content-Type'  => 'application/json'
            ],
            'json' => (array) $post
        );

        try {
            $response = $client->post($api . '/api/' . $url, $content);
            // echo "a"; exit();
            if (!is_array(json_decode($response->getBody(), true)));
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            try {
                //print_r($e);
                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    if (!is_array($response));
                    return json_decode($response, true);
                } else  return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            } catch (Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function postFileBearer($url, $name_field, $path, $filename, $bearer)
    {
        $api = env('APP_API_URL');
        $client = new Client;

        $content = array(
            'headers' => [
                'Authorization' => $bearer,
            ],
            'multipart' => [
                [
                    'name'     => $name_field,
                    'contents' => fopen($path, 'r'),
                    'filename' => $filename
                ]
            ]
        );

        try {
            $response = $client->post($api . '/api/' . $url, $content);
            // echo "a"; exit();
            if (!is_array(json_decode($response->getBody(), true)));
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            try {
                //print_r($e);
                if ($e->getResponse()) {
                    $response = $e->getResponse()->getBody()->getContents();
                    if (!is_array($response));
                    return json_decode($response, true);
                } else  return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            } catch (Exception $e) {
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function custom_number_format($n)
    {

        //return number_format($n);

        // first strip any formatting;
        $n = (0 + str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n / 1000000000000), 1) . ' T';
        else if ($n > 1000000000) return round(($n / 1000000000), 1) . ' B';
        else if ($n > 1000000) return round(($n / 1000000), 1) . ' M';
        else if ($n > 1000) return round(($n / 1000), 1) . ' K';

        return number_format($n);
    }

    public static function thousand_number_format($number)
    {
        if ($number != "") {
            return number_format($number, 0, '', '.');
        }
        return 0;
    }

    public static function hasAccess($granted, $features)
    {
        foreach ($granted as $g) {
            if (!is_array($features)) $features = session('granted_features');
            if (in_array($g, $features)) return true;
        }

        return false;
    }
    public static function isLogin()
    {
        $data = [];
        $userCheck = Myhelper::post('home/membership', $data);
        if (isset($userCheck['status']) && $userCheck['status'] == 'success') {
            return true;
        }
        return false;
    }
    public static function getNotifications()
    {
        $data = MyHelper::post('notifications/list', ['limit' => 10, 'page' => 1]);

        return ($data['status'] == 'success') ? $data['result'] : null;
    }

    public static function in_array_any($needles, $haystack)
    {
        return !empty((bool)array_intersect($needles, $haystack));
    }

    public static function in_array_all($needles, $haystack)
    {
        return empty((bool)array_diff($needles, $haystack));
    }

    public static function  safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public static function  safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public static function  passwordkey($id_user)
    {
        $key = md5("esemestester" . $id_user . "644", true);
        return $key;
    }
    public static function  getkey()
    {
        $depan = MyHelper::createrandom(1);
        $belakang = MyHelper::createrandom(1);
        $skey = $depan . "9gjru84jb86c9l" . $belakang;
        return $skey;
    }

    public static function  parsekey($value)
    {
        $depan = substr($value, 0, 1);
        $belakang = substr($value, -1, 1);
        $skey = $depan . "9gjru84jb86c9l" . $belakang;
        return $skey;
    }

    public static function  createrandom($digit)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        srand((float)microtime() * 1000000);
        $i = 0;
        $pin = '';

        while ($i < $digit) {
            $num = rand() % strlen($chars);
            $tmp = substr($chars, $num, 1);
            $pin = $pin . $tmp;
            $i++;
            // supaya char yg sudah tergenerate tidak akan dipakai lagi
            $chars = str_replace($tmp, "", $chars);
        }

        return $pin;
    }

    public static function throwError($e)
    {
        $error = $e->getFile() . ' line ' . $e->getLine();
        $error = explode('\\', $error);
        $error = end($error);
        return ['status' => 'failed with exception', 'exception' => get_class($e), 'error' => $error, 'message' => $e->getMessage()];
    }
    public static function  encryptkhusus($value)
    {
        if (!$value) {
            return false;
        }
        $skey = MyHelper::getkey();
        $depan = substr($skey, 0, 1);
        $belakang = substr($skey, -1, 1);
        $text = serialize($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($depan . MyHelper::safe_b64encode($crypttext) . $belakang);
    }

    public static function  encryptkhususpassword($value, $skey)
    {
        if (!$value) {
            return false;
        }
        $text = serialize($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim(MyHelper::safe_b64encode($crypttext));
    }

    public static function  decryptkhusus($value)
    {
        if (!$value) {
            return false;
        }
        $skey = MyHelper::parsekey($value);
        $jumlah = strlen($value);
        $value = substr($value, 1, $jumlah - 2);
        $crypttext = MyHelper::safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return unserialize(trim($decrypttext));
    }

    public static function  decryptkhususpassword($value, $skey)
    {
        if (!$value) {
            return false;
        }
        $crypttext = MyHelper::safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return unserialize(trim($decrypttext));
    }

    public static function  createRandomPIN($digit, $mode = null)
    {
        if ($mode != null) {
            if ($mode == "angka") {
                $chars = "1234567890";
            } elseif ($mode == "huruf") {
                $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            } elseif ($mode == "kecil") {
                $chars = "346789abcdefghjkmnpqrstuvwxy";
            }
        } else {
            $chars = "346789ABCDEFGHJKMNPQRSTUVWXY";
        }

        srand((float)microtime() * 1000000);
        $i = 0;
        $pin = '';

        while ($i < $digit) {
            $num = rand() % strlen($chars);
            $tmp = substr($chars, $num, 1);
            $pin = $pin . $tmp;
            $i++;
        }
        return $pin;
    }

    // news custom form webview
    // get value for form
    public static function oldValue($old_value, $autofill, $user, $is_autofill = 0)
    {
        if ($old_value != "") {
            return $old_value;
        }
        if ($is_autofill) {
            return self::autofill($autofill, $user);
        }
    }

    public static function autofill($autofill, $user)
    {
        if (empty($user)) {
            return "";
        } else {
            switch ($autofill) {
                case 'Name':
                    return $user['name'];
                    break;
                case 'Email':
                    return $user['email'];
                    break;
                case 'Phone':
                    return $user['phone'];
                    break;
                case 'Gender':
                    return $user['gender'];
                    break;
                case 'City':
                    return $user['city_name'];
                    break;
                case 'Birthday':
                    return date('d-M-Y', strtotime($user['birthday']));
                    break;

                default:
                    return "";
                    break;
            }
        }
    }

    public static function isRequiredMark($is_required = 0)
    {
        if ($is_required == 1) {
            return '<span class="required" aria-required="true"> * </span>';
        }
    }

    // news form data: check if string contain image or file link
    public static function checkFormData($string)
    {
        if (strpos($string, 'img/news-custom-form') !== false) {
            $link = env('APP_API_URL') . $string;
            return '<img data-src="' . $link . '" height="100px" alt="">';
        } elseif (strpos($string, 'upload/news-custom-form') !== false) {
            $link = env('APP_API_URL') . $string;
            return '<a href="' . $link . '" target="_blank">Download File</a>';
        } else {
            return $string;
        }
    }

    public static function before($th, $inthat)
    {
        $split = substr($inthat, 0, strpos($inthat, $th));
        return !empty($split) ? $split : $inthat;
    }
}
