<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{

    // Function to convert the validation MessageBag to plain text
    private function convertMessagesToPlainText(MessageBag $messages): string
    {
        return implode("\n", $messages->all());
    }

    // Signup Function
    public function signupFunction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            $plainTextErrorMessage = $this->convertMessagesToPlainText($validator->errors());
            return redirect()->back()->withErrors($plainTextErrorMessage);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->is_admin = 0;
        $status = $user->save();
        if ($status) {
            return redirect('/')->with('signupSuccess', 'Signup was successful!');
        } else {
            return redirect()->back()->withErrors("Something went wrong! Try again later.");
        }
    }

    // Login Function
    public function loginFunction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $plainTextErrorMessage = $this->convertMessagesToPlainText($validator->errors());
            return redirect()->back()->withErrors($plainTextErrorMessage);
        }
        $loginData = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (!auth()->attempt($loginData)) {
            return redirect()->back()->withErrors("Wrong credentials! Password does not match.");
        } elseif(auth()->user()->user_status == 'pending')
        {
            return redirect()->back()->with('error', 'Your account is awaiting approval from the administrator. Kindly reach out to the admin for further assistance.');
        }
        if(auth()->user()->is_admin === 1)
        {
            return redirect()->to('admin/dashboard');
        }
        return redirect('/dashboard');
    }

    // Forgot Password Function
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($validator->fails()) {
            $plainTextErrorMessage = $this->convertMessagesToPlainText($validator->errors());
            return redirect()->back()->withErrors($plainTextErrorMessage);
        }

        $otp = rand(1000, 9999);
        if (!User::where('email', $request->email)->update(['otp' => $otp])) {
            return redirect()->back()->withErrors('Unable to proccess. Please try again later');
        }
        Mail::to($request->email)->send(new OtpMail($otp));
        $request->session()->put('otp_email', $request->email);
        return redirect('/verify-otp');
    }

    // Verify OTP CODE FUNCTION
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_code' => 'required',
        ]);
        if ($validator->fails()) {
            $plainTextErrorMessage = $this->convertMessagesToPlainText($validator->errors());
            return redirect()->back()->withErrors($plainTextErrorMessage);
        }
        $userEmail = $request->session()->get('otp_email');
        $user = User::where('email', $userEmail)->first();
        if ($user->otp == intval($request->otp_code)) {
            return redirect('/new-password');
        }
        return redirect()->back()->withErrors('Invalid OTP Code!');
    }

    // Password Reset Function
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|max:32|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            $plainTextErrorMessage = $this->convertMessagesToPlainText($validator->errors());
            return redirect()->back()->withErrors($plainTextErrorMessage);
        }
        $userEmail = $request->session()->get('otp_email');
        $user = User::where('email', $userEmail)->first();
        $status = $user->update(['password' => bcrypt($request->password)]);
        if (!$status) {
            return redirect()->back()->withErrors("Something went wrong! Please try again.");
        }
        return redirect('/')->with('passwordSuccess', 'Password reset successfully!');
    }

    // Logout FUnction
    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    // Social Login Google Redirect
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    // Social login Callback
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('email', $user->email)->first();

            if ($finduser) {

                Auth::login($finduser);

                return redirect()->intended('dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => bcrypt('123456dummy')
                ]);

                Auth::login($newUser);

                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors("Something went wrong! Please try again.");
        }
    }
}
