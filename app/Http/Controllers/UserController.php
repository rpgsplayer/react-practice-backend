<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	public function register(Request $request) {
		$validator = Validator::make(
			[
		        'first_name' => $request->first_name,
		        'last_name' => $request->last_name,
		        'gender' => $request->gender,
		        'email' => $request->email,
		        'dob' => $request->dob,
		        'address' => $request->address,
		        'phone_no' => $request->phone_no,
		        'occupation' => $request->occupation,
		        'password' => $request->password,
		    ],
		    [
		        'first_name' => 'required|max:20',
		        'last_name' => 'required|max:20',
		        'gender' => 'required|max:6',
		        'email' => 'required|email:rfc,dns|unique:users|max:50',
		        'dob' => 'required|date|before:tomorrow',
		        'address' => 'required|max:1000',
		        'phone_no' => 'required|max:20',
		        'occupation' => 'max:25',
		        'password' => 'required|max:20',
		    ]
		);

		if($validator->fails()) {
			return $validator->messages();
		}
		else {
			$user = new User;
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->gender = $request->gender;
			$user->email = $request->email;
			$user->dob = $request->dob;
			$user->address = $request->address;
			$user->phone_no = $request->phone_no;
			$user->occupation = $request->occupation;
			$user->password = password_hash($request->password, PASSWORD_BCRYPT, ['cost' => 12]);
			$user->token = '';
			$user->save();

			return ['success' => true];
		}

	}

	public function login(Request $request) {
		$validator = Validator::make(
			[
		        'email' => $request->email,
		        'password' => $request->password
		    ],
		    [
		        'email' => 'required|email:rfc,dns|max:50',
		        'password' => 'required|max:20',
		    ]
		);

		if($validator->fails()) {
			return ['success' => false, 'message' => $validator->messages];
		}
		else {
			$user = User::where('email', $request->email)->first();
			if($user && password_verify($request->password, $user->password)) {
				$token = $this->generateRandomString();
				$user->update(['token' => $token]);
				return ['success' => true, 'token' => $token];
			} else {
				return ['success' => false, 'message' => 'Wrong email or password.'];
			}
		}

	}

	public function verifyToken(Request $request) {
		return ['success' => User::where('token', $request->token)->first() ? true : false];
	}

	function generateRandomString($length = 80) {
        $chars = '012345678dssd9abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charsLen = strlen($chars);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $charsLen - 1)];
        }
        return $str;
    }

}
