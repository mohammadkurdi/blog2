<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
//use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Models\User;
//use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\BaseTrait;



class RegisterController extends Controller
{
    //
    use BaseTrait;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return $this->sendError('Please Validate error',$validator->errors());
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('Muhammad');
        $success['name'] = $user->name;
        return $this->sendResponse($success,'User registered successfully');

    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password'=>$request->password]))
        {
            $user = Auth::user();
            $success['token'] = $user->createToken('Muhammad');
            $success['name'] = $user->name;
            return $this->sendResponse($success,'User login successfully');
        }
        else
        {
            return $this->sendError('Please check your email or password',['error'=>'Unauthorised']);
        }
    }
}

