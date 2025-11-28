<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password' =>'required|min:8',

        ]);

        if($validator->fails()){
            return response()->json(
                [
                    'sucess'=> false,
                    'message'=> 'validation error',
                    'data'=> $validator->errors()
                ],
                422);


        }


        $input = $request->only('first_name','last_name','email','password');
        $input['password'] = Hash::make($input['password']);
        
        $user = User::create($input);

        $token = $user->createToken($request->userAgent() ?? 'api-token')->plainTextToken;

        return response()->json(
            [
                'sucess'=>true,
                'access_token'=>$token,
                'name'=>$user->first_name,

            ],201);

    }

    public function login(Request $request)
    {
        $credientials = $request->only('email','password');

        if(!Auth::attempt($credientials))
        {
            return response()->json(['message'=>'Invalid credientials'],401);
        }

        $user = Auth::user();
        $token =$user->createToken('authToken')->plainTextToken;
        return response()->json(['user'=>$user,'token'=>$token]);
    }
}
