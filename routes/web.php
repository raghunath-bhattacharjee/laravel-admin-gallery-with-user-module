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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return redirect('login');
});

Auth::routes([
    'register' => false
]);

Route::group(['middleware' => ['auth.admin']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/admin/profile', 'HomeController@showProfile')->name('profile');
    Route::post('/admin/update_profile', 'HomeController@updateProfile')->name('update');

    Route::get('/admin/gallery','GalleryController@index')->name('geller');

    Route::get('/admin/view-create-gallery','GalleryController@getCreatePage');
    Route::post('/admin/create-gallery','GalleryController@create');

    Route::get('/admin/edit-gallery/{gallery}','GalleryController@editGalleryPage');
    Route::post('/admin/update-gallery/{gallery}','GalleryController@edit');

    Route::get('/admin/delete-gallery/{gallery}','GalleryController@destroy');

    Route::group(['middleware' => ['auth.admin', 'root.user']], function () {
        Route::get('/permissions', 'RoleController@index')->name('role');
        Route::post('/admin/create-role-permission', 'RoleController@createRoll');
        Route::get('/admin/delete-role/{role}', 'RoleController@deleteRole');

        Route::get('/admin/add-user', 'UserController@addUser');
        Route::post('/admin/create-user', 'UserController@createUser');
        Route::get('/admin/edit-user/{user}', 'UserController@showEditUser');
        Route::post('/admin/update-user/{user}', 'UserController@updateUser');
        Route::get('/admin/delete-user/{user}', 'UserController@deleteUser');
    });

    Route::get('/logout', function() {
        Auth::logout();
        Session::flush();
        return redirect('login');
    });
});
