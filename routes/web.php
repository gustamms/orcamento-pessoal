<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\ReceitaController;

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'receitas'], function () use ($router) {
    $router->get('/', 'ReceitasController@index');
    $router->get('/{id}', 'ReceitasController@show');
    $router->post('/', 'ReceitasController@store');
    $router->put('/{id}', 'ReceitasController@update');
    $router->delete('/{id}', 'ReceitasController@destroy');
});

$router->group(['prefix' => 'despesas'], function () use ($router) {
    $router->get('/', 'DespesasController@index');
    $router->get('/{id}', 'DespesasController@show');
    $router->post('/', 'DespesasController@store');
    $router->put('/{id}', 'DespesasController@update');
    $router->delete('/{id}', 'DespesasController@destroy');
});
