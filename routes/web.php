<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', function(){
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
        Route::get('/','DashboardController')->name('dashboard')->middleware('can:dashboard');
        Route::get('/profile', 'ProfileController@show')->name('profile.show')->middleware('can:profile-edit');
        Route::post('/profile', 'ProfileController@update')->name('profile.update')->middleware('can:profile-edit');


        // users
        Route::prefix('users')->group(function(){
            Route::get('/','UserController@index')->name('users.index')->middleware('can:user-view');
            Route::get('/create','UserController@create')->name('users.create')->middleware('can:user-create');
            Route::post('/create','UserController@store')->name('users.store')->middleware('can:user-create');
            Route::get('/{id}/edit','UserController@edit')->name('users.edit')->middleware('can:user-edit');
            Route::patch('/{id}/edit','UserController@update')->name('users.update')->middleware('can:user-edit');
            Route::delete('/{id}/delete','UserController@destroy')->name('users.destroy')->middleware('can:user-delete');
        });


        // roles
        Route::prefix('roles')->group(function(){
            Route::get('/','RoleController@index')->name('roles.index')->middleware('can:role-view');
            Route::get('/create','RoleController@create')->name('roles.create')->middleware('can:role-create');
            Route::post('/create','RoleController@store')->name('roles.store')->middleware('can:role-create');
            Route::get('/{id}/edit','RoleController@edit')->name('roles.edit')->middleware('can:role-edit');
            Route::patch('/{id}/edit','RoleController@update')->name('roles.update')->middleware('can:role-edit');
            Route::delete('/{id}/delete','RoleController@destroy')->name('roles.destroy')->middleware('can:role-delete');

            // role permissions
            Route::get('/{id}','RoleController@show')->name('roles.show')->middleware('can:rolepermission-view');
            Route::post('/{id}/permission','RoleController@permissionsUpdate')->name('roles.permissions-update')->middleware('can:rolepermission-update');

        });

        // permissions
        Route::prefix('permissions')->group(function(){
            Route::get('/','PermissionController@index')->name('permissions.index')->middleware('can:permission-view');
            Route::get('/create','PermissionController@create')->name('permissions.create')->middleware('can:permission-create');
            Route::post('/create','PermissionController@store')->name('permissions.store')->middleware('can:permission-create');
            Route::get('/{id}/edit','PermissionController@edit')->name('permissions.edit')->middleware('can:permission-edit');
            Route::patch('/{id}/edit','PermissionController@update')->name('permissions.update')->middleware('can:permission-edit');
            Route::delete('/{id}/delete','PermissionController@destroy')->name('permissions.destroy')->middleware('can:permission-delete');
        });

        // post-categories
        Route::prefix('post-categories')->group(function(){
            Route::get('/','PostCategoryController@index')->name('post-categories.index')->middleware('can:post-category-view');
            Route::get('/create','PostCategoryController@create')->name('post-categories.create')->middleware('can:post-category-create');
            Route::post('/create','PostCategoryController@store')->name('post-categories.store')->middleware('can:post-category-create');
            Route::get('/{id}/edit','PostCategoryController@edit')->name('post-categories.edit')->middleware('can:post-category-edit');
            Route::patch('/{id}/edit','PostCategoryController@update')->name('post-categories.update')->middleware('can:post-category-edit');
            Route::delete('/{id}/delete','PostCategoryController@destroy')->name('post-categories.destroy')->middleware('can:post-category-delete');
        });

         // posts
         Route::prefix('posts')->group(function(){
            Route::get('/','PostController@index')->name('posts.index')->middleware('can:post-view');
            Route::get('/create','PostController@create')->name('posts.create')->middleware('can:post-create');
            Route::post('/create','PostController@store')->name('posts.store')->middleware('can:post-create');
            Route::get('/{id}/edit','PostController@edit')->name('posts.edit')->middleware('can:post-edit');
            Route::patch('/{id}/edit','PostController@update')->name('posts.update')->middleware('can:post-edit');
            Route::delete('/{id}/delete','PostController@destroy')->name('posts.destroy')->middleware('can:post-delete');
        });

    });
});
