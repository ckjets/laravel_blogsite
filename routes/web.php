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

// '/' = only localhost:8000/
// '/hello' = localhost:8000/hello
//view = views > index.blade.php appears.
//(foldername)pages.about(filename)
//Only return value appears.
//static(not change) route.
Route::get('/', 'PagesController@index');
Route::get('/about','PagesController@about');
Route::get('/services', 'PagesController@services');

//Route::resouceを指定することで、CRUDルーティングを一度に行うことができる
//https://qiita.com/sympe/items/9297f41d5f7a9d91aa11
Route::resource('posts','PostsController');
Route::get('/posts','PostsController@index');
Route::get('/create','PostsController@create');


//Authentication
Auth::routes();
Route::get('/dashboard','DashboardController@index');



//dynamic(value hange) route
//inputURL localhost:8000/user/(parameter value)/(parameter value)
// Route::get('/user/{id}/{name}', function ($id,$name) {
//     return 'This is the user '.$name.' with an id of '.$id;
// });
