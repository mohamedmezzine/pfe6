<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    /*ingrediant*/
    Route::get('/ingredients', 'IngredientController@index')->name('ingredients.index');
    Route::get('/ingredients/create', 'IngredientController@create')->name('ingredients.create');
    Route::post('/ingredients', 'IngredientController@store')->name('ingredients.store');
    Route::get('/ingredients/{id}', 'IngredientController@show')->name('ingredients.show');
    Route::get('/ingredients/{id}/edit', 'IngredientController@edit')->name('ingredients.edit');
    Route::put('/ingredients/{id}', 'IngredientController@update')->name('ingredients.update');
    Route::delete('/ingredients/{id}', 'IngredientController@destroy')->name('ingredients.destroy');

});
