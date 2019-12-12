<?php

namespace App\Api\V1\Controllers\Auth;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;

class LoginController extends Controller
{
   /**
    * Log the user in
    *
    * @param LoginRequest $request
    * @param JWTAuth $JWTAuth
    * @return \Illuminate\Http\JsonResponse
    */
   public function login(LoginRequest $request, JWTAuth $JWTAuth)
   {

      $auth = Auth::guard();

      $credentials = $request->only(['email', 'password']);

      try {

         $token = $auth->attempt($credentials);

         if (!$token) {
            throw new AccessDeniedHttpException('Your Credentials did not match!');
         }

         if (!$auth->user()->isConfirmed()) {

            $auth->logout();

            throw new AccessDeniedHttpException('Your Account need to confirmed! Please check your Email.');
         }

         return response()
            ->json([
               'status' => 'ok',
               'user' => $auth->user(),
               'token' => $token,
               'expires_in' => $auth->factory()->getTTL() * 60
            ]);
      } catch (JWTException $e) {
         throw new HttpException(500);
      }
   }
}