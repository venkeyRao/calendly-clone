<?php

namespace App\Api\V1\Controllers;

use Hash;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, PasswordReset};
use App\Api\V1\Controllers\Controller;
use App\Api\V1\Resources\UserResource;
use App\Api\V1\Requests\Login\LoginRequest;
use App\Api\V1\Requests\User\{RegisterRequest, ForgetPasswordRequest, SetPasswordRequest};

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = array('email' => request('username'), 'password' => request('password'));
        if(! $token = auth('api')->attempt($credentials)){
            return response()->json(['error' => 'Unauthorized'], 401);
        }     
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth('api')->user();
        return (new UserResource($user))->response()->setStatusCode(200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json(['access_token'=> $token, 'token_type'=> 'bearer']);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::forceCreate([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'mobile' => $request->mobile,
        ]);
        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function forgotPassword(ForgetPasswordRequest $request)
    {
        $user = User::where('email', $request->email_id)->firstOrFail();
        $token = app('auth.password.broker')->createToken($user);

        $user->ForgotPasswordNotification($token);
        return response()->json(['message'=>"Notification Sent"])->setStatusCode(200);
    }

    public function setPassword(SetPasswordRequest $request)
    {
        $user = User::where('email', $request->email_id)->firstOrFail();
        $resetToken = PasswordReset::where('email', $request->email_id)->firstOrFail();
        if(Hash::check($request->token, $resetToken['token']))
        {
            $user->password = Hash::make($request->password);
            $user->save();
            return (new UserResource($user))->response()->setStatusCode(200);
        }
        else
        {
            return response()->json(['message'=>"Token Mismatch"])->setStatusCode(422);
        }
    }
}
