<?php
/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'employees'], function () use ($router) {

        $router->get('/', ['uses' => 'EmployeeAPIController@index']);

        $router->post('/', ['uses' => 'EmployeeAPIController@store']);
    
        $router->delete('/', ['uses' => 'EmployeeAPIController@delete']);
    
        $router->put('/', ['uses' => 'EmployeeAPIController@update']);
    });
});