<?php

use \Illuminate\Support\Facades\Route;

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

Route::get('/', 'PostController@index');

Route::get('/posts', 'PostController@index')->name('list_posts');

Route::group(['prefix' => 'posts'], function () {

    Route::get('/drafts', 'PostController@drafts')
        ->name('list_drafts')
        ->middleware('auth');

    Route::get('/show/{id}', 'PostController@show')
        ->name('show_post');

    Route::get('/create', 'PostController@create')
        ->name('create_post')
        ->middleware('can:create-post');

    Route::post('/create', 'PostController@store')
        ->name('store_post')
        ->middleware('can:create-post');

    Route::get('/edit/{post}', 'PostController@edit')
        ->name('edit_post')
        ->middleware('can:update-post,post');

    Route::post('/edit/{post}', 'PostController@update')
        ->name('update_post')
        ->middleware('can:update-post,post');

    // using get to simplify
    Route::get('/publish/{post}', 'PostController@publish')
        ->name('publish_post')
        ->middleware('can:publish-post');
});

/*
 * Admin section
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'can:administrate']], function () {

    /**
     * Roles
     */
    Route::group(['prefix' => 'roles'], function () {

        Route::get('/', 'RoleController@index')
            ->name('list_roles');

        Route::get('/show/{id}', 'RoleController@show')
            ->name('show_role');

        Route::get('/create', 'RoleController@create')
            ->name('create_role');

        Route::post('/store', 'RoleController@store')
            ->name('store_role');

        Route::get('/edit/{role}', 'RoleController@edit')
            ->name('edit_role');

        Route::post('/update/{role}', 'RoleController@update')
            ->name('update_role');

        Route::post('/delete/{role}', 'RoleController@delete')
            ->name('delete_role');
    });

    /**
     *
     * Permissions
     */
    Route::group(['prefix' => 'permissions'], function () {

        Route::get('/', 'PermissionController@index')
            ->name('list_permissions');

        Route::get('/show/{id}', 'PermissionController@show')
            ->name('show_permission');

        Route::get('/create', 'PermissionController@create')
            ->name('create_permission');

        Route::post('/store', 'PermissionController@store')
            ->name('store_permission');

        Route::get('/edit/{permission}', 'PermissionController@edit')
            ->name('edit_permission');

        Route::post('/update/{permission}', 'PermissionController@update')
            ->name('update_permission');

        Route::post('/delete/{permission}', 'PermissionController@delete')
            ->name('delete_permission');
    });

    /**
     * Users
     */
    Route::group(['prefix' => 'users'], function () {

        Route::get('/', 'UserController@index')
            ->name('list_users');

        Route::get('/show/{id}', 'UserController@show')
            ->name('show_user');

        Route::get('/edit/{id}', 'UserController@edit')
            ->name('edit_user');

        Route::post('/update/{id}', 'UserController@update')
            ->name('update_user');

        Route::post('/delete/{id}', 'UserController@delete')
            ->name('delete_user');
    });
});
