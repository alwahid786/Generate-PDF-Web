<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

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
            'email' => 'required|email',
            'password' => 'required|min:8',
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            $plainTextErrorMessage = $this->convertMessagesToPlainText($validator->errors());
            return redirect()->back()->withErrors($plainTextErrorMessage);
        }
        dd('coming');
    }
}
