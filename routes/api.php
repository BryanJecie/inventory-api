<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */

$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {

        $api->post('signUp', Config('access.path.ctrl').'\\Auth\\SignUpController@signUp');
        $api->post('login', Config('access.path.ctrl').'\\Auth\\LoginController@login');

        $api->post('recovery', Config('access.path.ctrl').'\\Auth\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', Config('access.path.ctrl').'\\Auth\\ResetPasswordController@resetPassword');

        $api->get('logout', Config('access.path.ctrl').'\\Auth\\LogoutController@logout');
        $api->post('refresh', Config('access.path.ctrl').'\\Auth\\RefreshController@refresh');
        $api->get('me', Config('access.path.ctrl').'\\Auth\\UserController@me');

    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {

         $api->group(['prefix' => 'suppliers'], function(Router $api) {
            $api->get('/', Config('access.path.ctrl').'\\Suppliers\\SuppliersController@index');
        });

        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', ['middleware' => 'jwt.refresh', function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
