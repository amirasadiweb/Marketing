<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BasicController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class AuthController extends BasicController
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
    public function register(Request $request)
    {

        try {

            $data=$this->validateRequest('create');
            $data['password']=bcrypt($request['password']);

            $user = User::create($data);
            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, 201);

        }
        catch (\Exception $exception) {

            return $this->sendError('Operation Failed', $exception->getMessage(), 500);
        }


    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
    public function login(Request $request)
    {

        try {

            $data=$this->validateRequest('login');

            // Check email
            $user = User::where('email', $data['email'])->first();

            // Check password
            if(!$user || !Hash::check($data['password'], $user->password)) {
                return response([
                    'message' => 'Bad Request'
                ], 401);
            }

            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, 201);

        }
        catch (\Exception $exception) {

            return $this->sendError('Operation Failed', $exception->getMessage(), 500);
        }


    }


    /**
     * @param Request $request
     * @return string[]
     */
    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }


    /**
     * @param $action
     * @return array
     */
    protected function validateRequest($action)
    {
        if($action=='create') {
            return request()->validate([
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required|confirmed',
                'role' => 'required'
            ]);
        }else{
            return request()->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        }

    }

}
