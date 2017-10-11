<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Event;
use Reminder;
use Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use DB;
use App\User;
use Validator;


class AuthController extends Controller
{

    /**
     * Create a new Frontend\AuthController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('sentinel_guest', ['except' => 'getLogout']);
    // }

    public function index()
    {
        return view('frontend.login');
    }


    /**
     * Admin Handle login request.
     *
     * @param  \App\Http\Requests\Auth\WebLoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $backToLogin = redirect('login')->withInput();
        $this->validate($request, 
            [
                'email' => 'required',
                'password' => 'required'
            ]);

        $findUser = Sentinel::findByCredentials(['login' => $request->input('email')]);
        // If we can not find user based on email...
        if (! $findUser) {

            return $backToLogin->with('error', 'user tidak ditemukan');
        }

        try {
            $remember = (bool) $request->input('remember_me');
            // If password is incorrect...
            if (! Sentinel::authenticate($request->all(), $remember)) {
                return $backToLogin->with('error', 'password yang anda masukan salah');
            }
            if (strtolower(Sentinel::check()->roles[0]->slug) != 'admin' && !array_key_exists('admin', Sentinel::check()->roles[0]->permissions)) {
                Sentinel::logout();
                return $backToLogin->with('error', 'tidak ada akses');
            }

            if ($findUser->is_active == 0) {
                Sentinel::logout();
                return $backToLogin->with('error', 'user tidak aktif');
            }

            return redirect('dashboard');
        } catch (ThrottlingException $e) {
            $error = 'Too many attempts!';
        } catch (NotActivatedException $e) {
            $error = 'Please activate your account before trying to log in.';
        }

        return $backToLogin->with('error', $error);
    }

    /**
     * Admin Logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Sentinel::logout();
        return redirect('login');
    }

    /**
     * Reset password page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getResetPassword()
    {
        return view('frontend.auth.forgot');
    }

    /**
     * Process reset password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postResetPassword(Request $request)
    {
        $this->validate($request,
                [
                'email'   => 'required|email',
                ]);
        $findUser = Sentinel::findByCredentials(['login' => $request->input('email')]);
        if (! $findUser) {
            return redirect('password-reset')->with('error','Gagal reset password');
        }
        if (Reminder::exists($findUser)) {
            $reminder = Reminder::exists($findUser);
            $reminder->delete();

        }
        $reminder = Reminder::create($findUser);
        $data_email = array('id'=>$findUser->id,
                            'email'=> $findUser->email,
                            'username'=>$findUser->username,
                            'subject_email'=>'Reset Password',
                            'activation_code'=>$reminder->code,
                            'url'=>route('password-reset', [$findUser->id, $reminder->code])
                            );
        $template = 'email.reset_password';
        $email = New Email;
        $email->sendEmail($template, $data_email);
        return redirect('login')->with('errror', 'Password telah berhasil di reset');
    }

    public function sendEmailResetPassword($data)
    {
        $mail = Mail::queue('email.reset_password', $data,
            function($message) use($data) {
                $message->from('', '');
                $message->to($data['email'], $data['email'])->subject($data['subject_email']);
            });
    }

    /**
    * Verify code for reset password .
    * paths url    : reset-password
    * methode      : get
    * @return Response
    */
    public function verifyResetPassword($id,$code)
    {
        $checkCode = User::verifyCodeResetPassword($id,$code);
        if ($checkCode['code'] == 200) {
            $data['id'] = $id;
            $data['code'] = $code;
            $data['form'] = [
                'url' => route('post-admin-change-password'),
                'id' => 'form-forgot',
                'autocomplete' => 'off',
            ];
            return view('frontend.auth.reset', $data);
        } else {
            return redirect('login')->with('error', 'Login request has expired');
        }

    }

    /**
     * Process change password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postChangePassword(ForgotRequest $request)
    {
        $user = Sentinel::findById($request->input('id'));
        Reminder::complete($user, $request->input('code'), $request->input('password'));
        return redirect('login')->with('error', 'password telah berhasil diubah');
    }
}

