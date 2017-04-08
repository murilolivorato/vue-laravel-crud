<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




/* -----------------------------------------------------------------------------------  PRODUCT CATEGORY */


Route::post('vue-crud/store' , [
    'uses'        => 'VueCrudController@store' ,
    'as'          => 'vue_crud.store'

]);

Route::post('vue-crud/{id}/edit' , [
    'uses'        => 'VueCrudController@edit' ,
    'as'          => 'vue_crud.edit'
]);


Route::post('vue-crud/update' , [
    'uses'        => 'VueCrudController@update' ,
    'as'          => 'vue_crud.update'
]);

Route::post('vue-crud/delete' , [
    'uses'        => 'VueCrudController@delete' ,
    'as'          => 'vue_crud.delete'
]);


Route::get('vue-crud/load-display' , [
    'uses'        => 'VueCrudController@load_display' ,
    'as'          => 'vue_crud.load_display'
]);

Route::get('vue-crud' , [
    'uses'        => 'VueCrudController@index' ,
    'as'          => 'vue_crud'
]);