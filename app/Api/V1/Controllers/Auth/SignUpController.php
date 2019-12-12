<?php

namespace App\Api\V1\Controllers\Auth;

use Config;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use App\Events\NewUserHasRegisteredEvent;
use App\Repositories\Auth\UserRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SignUpController extends Controller
{
   private $userRepo;

   /**
    * SignUpController constructor.
    * @param UserRepository $userRepository
    */
   public function __construct(UserRepository $userRepository)
   {
      $this->userRepo = $userRepository;
   }

   /**
    * @param SignUpRequest $request
    * @param JWTAuth $JWTAuth
    * @return \Illuminate\Http\JsonResponse
    */
   public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
   {
      $user = $this->userRepo->create($request->all());

      if (!Config::get('boilerplate.sign_up.release_token')) {
         // add event here
         // event send email

         // event(new NewUserHasRegisteredEvent($user));
         // Mail::to($user->email)->send(new WelcomeNewUser());

         return response()->json([
            'status' => 'ok',
            'message' => 'Successfully Save.. PLease check your email to confirm',
            'email' => $user->email
         ], 201);
      }

      $token = $JWTAuth->fromUser($user);

      return response()->json([
         'status' => 'ok',
         'token' => $token
      ], 201);
   }
}