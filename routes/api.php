<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Api\V1\Controllers', 'middleware' => 'bindings'], function ($api) {

    $api->get('/', function () {
        return ['message' => 'Calendly Clone APP API Version 1'];
    });

    $api->post('refresh', 'AuthController@refresh');

    $api->group(['prefix' => 'auth'], function ($api) {
        $api->post('login', 'AuthController@login');
        $api->post('register', 'AuthController@register');
        $api->post('forgot-password', 'AuthController@forgotPassword');
        $api->post('set-password', 'AuthController@setPassword');
    });

    $api->group(['middleware' => 'api.auth'], function ($api){
        // Any Authenticated Users

        $api->group(['prefix' => 'auth'], function ($api) {
            $api->post('logout', 'AuthController@logout');
            $api->post('me', 'AuthController@me');
        });

        $api->group(['prefix' => 'calendar'], function ($api) {
            $api->post('/', 'CalendarController@store');
        });
    });

    $api->group(['prefix' => 'calendar'], function ($api) {
        $api->get('/', 'CalendarController@index');
        $api->get('/{slot}', 'CalendarController@show');
        $api->post('/{slot}', 'CalendarController@bookSlot');
    });


});
