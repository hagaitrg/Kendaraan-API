<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use App\Repository\ResponseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $token = true;
    private $res;
    public function __construct(ResponseRepository $res)
    {
        $this->res = $res;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|string|min:6|max:50',
        ]);

        if ($validator->fails()) {
            return $this->res->sendError(400, $validator->errors(), null);
        }

        try {
            $data = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password)
            ]);
            return $this->res->sendSuccess(200, 'User Created Successfully', $data);
        } catch (\Throwable $th) {
            return $this->res->sendError(500, 'Failed Create User', $th->getMessage());
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50',
        ]);

        if ($validator->fails()) {
            return $this->res->sendError(400, $validator->errors(), null);
        }

        $data = $request->only('email','password');
        $jwt_token = null;

        try {
            if (!$jwt_token = JWTAuth::attempt($data)) {
                return $this->res->sendError(400, 'Login Credential are invalid', null);
            }
        } catch (JWTException $e) {
            return $this->res->sendError(500, 'Could not create token', $e->getMessage());
        }

        return $this->res->sendSuccess(200, 'Successfully created token', $this->generateToken($jwt_token));
    }

    public function logout()
    {
        auth()->logout();

        return $this->res->sendSuccess(200, 'Successfully Logged Out', null);
    }

    public function refresh()
    {
        return $this->generateToken(auth()->refresh());
    }

    protected function generateToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()*60,
        ]);
    }
}
