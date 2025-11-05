<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Customer\LoginRegisterRequest;
use App\Http\Services\Message\Mail\Mail;
use App\Http\Services\Message\Message;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginRegisterController extends Controller
{
    public function form()
    {
        return view('customer.auth.login-register');
    }

    public function loginRegister(LoginRegisterRequest $request, Message $message)
    {
        $inputs = $request->all();
        $id = $inputs['id'];

        // if  type id === email
        if (filter_var($id,FILTER_VALIDATE_EMAIL)){
            $type = 'mail'; // type email
            $user = User::where('email',$id)->first();
            if (empty($user)){
                $newUser['email'] = $id;
            }
        }
        // if  type id === mobile
        elseif(preg_match("/^(\+98|98|0)9\d{9}$/", $id)){
            return redirect()->back()->withErrors(['id' => 'سرویس ارسال پیامک فعال نمی باشد.لطفا برای دیافت کد فعال سازی از ایمیل خود استفاده کنید']);
            $type = 'sms'; // type mobile
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

        $otpCode = Otp::generateCode();
        $generateToken = Str::random(60);

        if (empty($user))
        {
            $newUser['password'] = Hash::make(2423432423);
            $newUser['activation'] = 1;
            $user = User::create($newUser);
           $otpInputs =
               [
                 'token' => $generateToken,
                 'user_id' => $user->id,
                 'otp_code' => $otpCode,
                 'login_id' => $id,
                 'type' => $type,
               ];
           Otp::create($otpInputs);
      }
        // send message
        $details = [
            'title' => 'ایمیل فعال سازی',
            'body' => " کد فعال سازی شما : $otpCode"
        ];

        $send = $message->create($type)->to($id)->from('noreply@gamil.com', 'amazone')
            ->subject('کد احراز حویت')->text($details)->send();
        dd($send);

    }

}
