<?php

use Illuminate\Routing\Router;
use Orchestra\Support\Facades\Foundation;

/*
|--------------------------------------------------------------------------
| Frontend Routing
|--------------------------------------------------------------------------
*/

Foundation::group('blupl/franchise', 'franchise', ['namespace' => 'Blupl\Franchises\Http\Controllers'], function (Router $router) {
    $router->resource('management', 'ManagementController');
    $router->resource('registration', 'RegistrationController');
    $router->get('/', 'RegistrationController@index');
});

/*
|--------------------------------------------------------------------------
| Backend Routing
|--------------------------------------------------------------------------
*/

Foundation::namespaced('Blupl\Franchises\Http\Controllers\Admin', function (Router $router) {
    $router->group(['prefix' => 'franchise'], function (Router $router) {
        $router->get('accredit_home', 'HomeController@accredit_home');
        $router->get('/', 'HomeController@index');
        $router->match(['GET', 'HEAD', 'DELETE'], 'profile/{roles}/delete', 'HomeController@delete');

    });
});
