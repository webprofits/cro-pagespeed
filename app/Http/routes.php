<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');
Route::get('/v1', 'WelcomeController@index');
Route::get('v2', 'WelcomeController@index_two');

Route::get('home', 'HomeController@index');

Route::get('endpoint', 'PageSpeedAPIController@endpoint');
Route::post('endpoint', 'PageSpeedAPIController@endpoint');

Route::get('results', 'PageSpeedController@resultsInfusion');
Route::post('results', 'PageSpeedController@results');

Route::get('results2', 'PageSpeedController@resultsInfusion2');
Route::post('results2', 'PageSpeedController@results2');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('test', function() {
    $regex = '/^(?:(?:\((?=\d{3}\)))?(\d{3})(?:(?<=\(\d{3})\))?[\s.\/-]?)?(\d{3})[\s\.\/-]?(\d{4})\s?(?:(?:(?:(?:e|x|ex|ext)\.?|extension)\s?)(?=\d+)(\d+))?$/x';
    $validator = Validator::make(
        ['phone' => '(800) 800 8000'],
        ['phone' => 'required|regex:' . $regex]
    );

    if ($validator->fails()) {
        echo "!";
    }
});
