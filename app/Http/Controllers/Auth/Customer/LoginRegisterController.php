<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Customer\LoginRegisterRequest;
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
            $type = 1; // type mobile
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

        if (empty($user))
        {
            $newUser['password'] = Hash::make(2423432423);
            $newUser['activation'] = 1;
            $user = User::create($newUser);

           $otpCode = Otp::generateCode();
           $generateToken = Str::random(60);
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

    }

}
