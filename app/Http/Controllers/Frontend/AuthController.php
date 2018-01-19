<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Event;
use Reminder;
use Sentinel;
use Activation;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use DB;
use App\User;
use Validator;
use Socialite;
use Mail;
use App\Mail\ResetPassword;
use App\Mail\Register;


class AuthController extends Controller
{

    public function index()
    {
        return view('frontend.login');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try 
        {
            $user = Socialite::driver($provider)->user();
            return $user;
        }catch(\Exception $e)
        {
            return redirect('/');
        }

        // $user->token;
    }

    public function postLogin(Request $request)
    {
        $backToLogin = redirect('login')->withInput();
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required'
            ]);

        $findUser = Sentinel::findByCredentials(['email' => $request->input('email')]);
        // If we can not find user based on email...
        if (!$findUser)
        {
            return $backToLogin->with('error', 'user tidak ditemukan');
        }

        try {
            $remember = (bool) $request->input('remember_me');
            // If password is incorrect...
            if (!Sentinel::authenticate($request->all(), $remember)) {
                return $backToLogin->with('error', 'password yang anda masukan salah');
            }

            return redirect('/');
        } catch (ThrottlingException $e) {
            $error = 'Too many attempts!';
        } catch (NotActivatedException $e) {
            $error = 'Please activate your account before trying to log in.';
        }
        return $backToLogin->with('error', $error);
    }

    public function getLogout()
    {
        Sentinel::logout();
        return redirect('/');
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
        $findUser = Sentinel::findByCredentials(['email' => $request->input('email')]);
        if (!$findUser) {
            return redirect('password-reset')->with('error','Gagal reset password');
        }
        if (Reminder::exists($findUser)) {
            $reminder = Reminder::exists($findUser);
            $reminder->delete();

        }
        $reminder = Reminder::create($findUser);
        $data = array('id'=>$findUser->id,
                            'email'=> $findUser->email,
                            'first_name'=>$findUser->first_name,
                            'subject_email'=>'Reset Password',
                            'activation_code'=>$reminder->code,
                            'url'=>route('reset-password', [$findUser->id, $reminder->code])
                            );
        Mail::to($data['email'])->send(new ResetPassword($data));
        return redirect('password-reset')->with('error', 'Password telah berhasil di reset, harap cek email anda');
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
            return view('frontend.auth.reset-form', $data);
        } else {
            return redirect('login')->with('error', 'Reset Password Gagal');
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

        /**
     * Process post register.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $this->validate($request,
                [
                'email'   => 'required|email|unique:users',
                'password' => 'confirmed|required'
                ]);
        $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
        ];

        $user = Sentinel::register($credentials); 
        $activation = Activation::create($user);
        $data = array('id'=>$activation->id,
                    'email'=> $user->email,
                    'first_name'=>$user->first_name,
                    'subject_email'=>'Activation Account',
                    'activation_code'=>$activation->code,
                    'url'=>route('activation', [$user->id, $activation->code])
                    );
        Mail::to($request->email)->send(new Register($data));
        return redirect('login')->with('error', 'Registrasi telah berhasil, silahkan cek email untuk melakukan aktivasi');
    }
}
