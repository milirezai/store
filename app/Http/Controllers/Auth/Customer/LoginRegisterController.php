<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Customer\LoginRegisterRequest;
use App\Http\Services\Message\Mail\Mail;
use App\Http\Services\Message\Message;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginRegisterController extends Controller
{
    protected $message;
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function form()
    {
        return view('customer.auth.login-register');
    }

    public function loginRegister(LoginRegisterRequest $request)
    {
        $inputs = $request->all();
        $id = $inputs['id'];

        // if  type id === email
        if (filter_var($id,FILTER_VALIDATE_EMAIL)){
            $type = 1; // type email
            $user = User::where('email',$id)->first();
            if (empty($user)){
                $newUser['email'] = $id;
            }
        }
        // if  type id === mobile
        elseif(preg_match("/^(\+98|98|0)9\d{9}$/", $id)){
            return redirect()->back()->withErrors(['id' => 'سرویس ارسال پیامک فعال نمی باشد.لطفا برای دیافت کد فعال سازی از ایمیل خود استفاده کنید']);
            $type = 0; // type mobile
            $user = User::where('mobile',$id)->first();

            // all mobile numbers are in on format 9** *** ***
            $id = ltrim($id, '0');
            $id = substr($id, 0, 2) === '98' ? substr($id, 2) : $id;
            $id = str_replace('+98', '', $id);

            $user = User::where('mobile', $id)->first();
            if(empty($user)){
                $newUser['mobile'] = $id;
            }

        }
        else{
            return redirect()->back()->withErrors(['id' => 'اطلاعات وارد شده معتبر نمی باشد']);
        }

        $otpCode = Otp::code();
        $generateToken = Str::random(60);

        if (empty($user))
        {
            $newUser['password'] = Hash::make(2423432423);
            $newUser['activation'] = 1;
            $user = User::create($newUser);

      }
        $otpInputs =
            [
                'token' => $generateToken,
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'login_id' => $id,
                'type' => $type,
            ];
        Otp::create($otpInputs);

        // send message
        $details = [
            'title' => 'ایمیل فعال سازی',
            'body' => " کد فعال سازی شما : $otpCode"
        ];

        $type = $type === 0 ? 'mobile' : 'mail';
        $this->message->create($type)->to($id)->from('noreply@gamil.com', 'amazone')
            ->subject('کد احراز حویت')->text($details)->send();
        return  redirect()->route('auth.customer.login-confirm.form',$generateToken);


    }


    public function confirmForm($token)
    {
        $otp = Otp::where('token',$token)->first();
        if (empty($otp)){
            return redirect()->route('auth.customer.login-register.form')->withErrors(['id' => 'توکن شما نا معتبر است.']);
        }
            return view('customer.auth.login-confirm',compact('token','otp'));
    }


    public function loginConfirm($token, LoginRegisterRequest $request)
    {
        $inputs = $request->all();
        $otp = Otp::where('token',$token)->where('used',0)
            ->where('created_at','>=',Carbon::now()->subMinute(5)->toDateTimeString())->first();

        if (empty($otp)){
            return redirect()->route('auth.customer.login-confirm.form',$token)->withErrors(['otp_code' => 'کد یک بار مصرف نا معتبر است.']);
        }
        // otp not match
        if ($otp->otp_code != $inputs['otp_code']){
            return redirect()->route('auth.customer.login-confirm.form',$token)->withErrors(['otp_code' => 'کد یک بار مصرف نادرست است.']);
        }

        // everything is ok :
        $otp->update(['used' => 1]);
        $user = $otp->user()->first();

        if ($otp->type == 0 && empty($user->mobile_verified_at)){
            $user->update(['mobile_verified_at' => Carbon::now()]);
        }elseif ($otp->type == 1 && empty($user->email_verified_at)){
            $user->update(['email_verified_at' => Carbon::now()]);
        }
        Auth::login($user);
        return redirect()->route('customer.home');
    }


    public function loginResendOtp($token)
    {
        $otp = Otp::where('token', $token)
            ->where('created_at', '<=', Carbon::now()->subMinutes(5)->toDateTimeString())->first();

        if (empty($otp)){
            return redirect()->route('auth.customer.login-register.form')
                ->withErrors(['id' => 'توکن شما نا معتبر است.']);
        }

        $user = $otp->user()->first();
        $otpCode = Otp::code();
        $token = Str::random(60);

        $otpInputs =
            [
                'token' => $token,
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'login_id' => $otp->login_id,
                'type' => $otp->type,
            ];
        Otp::create($otpInputs);

        $details = [
            'title' => 'ایمیل فعال سازی',
            'body' => " کد فعال سازی شما : $otpCode"
        ];

        $type = $otp->type === 0 ? 'mobile' : 'mail';
        $this->message->create($type)->to($otp->login_id)->from('noreply@gamil.com', 'amazone')
            ->subject('کد احراز حویت')->text($details)->send();

        return redirect()->route('auth.customer.login-confirm.form', $token);

    }


    public function logout()
    {
        auth()->logout();
        return redirect()->route('customer.home');
    }

}
