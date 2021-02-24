<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Str;class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::query()->create($input);
        $success['token'] =  $user->token;
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;
        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request)
    {
        $validator =Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $success = $request->email;
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Validation Error.', $validator->errors());
        }

    }

    public function logout(Request $request){
        $success = $request->email;
        Auth::logout();
        return $this->sendResponse($success, 'User logout successfully.');
    }
}
