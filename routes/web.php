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
    // return view('welcome');
    return redirect('login');
});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Authentication Routes...

Route::get('/chgpwd', 'HomeController@showChgpwdForm');
Route::post('/chgpwd', 'HomeController@chgpwd')->name('chgpwd');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes are disabled because they are handled by admin
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// User
Route::get('/users', 'UserManager\UserController@index');
Route::get('/users/list', 'UserManager\UserController@list');
Route::post('/users/create', 'UserManager\UserController@create');
Route::post('/users/update', 'UserManager\UserController@update');
Route::post('/users/destroy', 'UserManager\UserController@destroy');
Route::post('/users/toggle-status', 'UserManager\UserController@toggleStatus');

// Permissions
Route::get('/permissions', 'UserManager\PermissionController@index');
Route::get('/permissions/list', 'UserManager\PermissionController@list');
Route::post('/permissions/insert', 'UserManager\PermissionController@insert');
Route::post('/permissions/update', 'UserManager\PermissionController@update');
Route::post('/permissions/destroy', 'UserManager\PermissionController@destroy');
Route::get('/permissions/roles/show', 'UserManager\PermissionController@showRoles');
Route::get('/permissions/roles/list', 'UserManager\PermissionController@listPermissionRoles');
Route::post('/permissions/roles/set', 'UserManager\PermissionController@setRole');

// Roles
Route::get('/roles', 'UserManager\RoleController@index');
Route::get('/roles/list', 'UserManager\RoleController@list');
Route::post('/roles/insert', 'UserManager\RoleController@insert');
Route::post('/roles/update', 'UserManager\RoleController@update');
Route::post('/roles/destroy', 'UserManager\RoleController@destroy');
Route::get('/roles/permissions/show', 'UserManager\RoleController@showPermissions');
Route::get('/roles/permissions/list', 'UserManager\RoleController@listRolePermissions');
Route::post('/roles/permissions/set', 'UserManager\RoleController@setPermission');


Route::match(['get', 'post'], 'settings', function(){
	return view('user_manager.index');
});

// Export Details
Route::get('/activities', 'UserManager\ActivityController@index');
Route::get('/activities/list', 'UserManager\ActivityController@list');
Route::get('/activities/list/model-activity-name', 'UserManager\ActivityController@listModelActivityNames');


// User
Route::get('/codes', 'CodeController@index');
Route::get('/codes/list', 'CodeController@list');
Route::get('/codes/list-categories', 'CodeController@listCategories');
Route::get('/codes/insert', 'CodeController@showInsert');
Route::post('/codes/insert', 'CodeController@insert');
Route::get('/codes/update', 'CodeController@showUpdate');
Route::post('/codes/update', 'CodeController@update');
Route::post('/codes/destroy', 'CodeController@destroy');
Route::post('/codes/destroy/media', 'CodeController@destroyMedia');




