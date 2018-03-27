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
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// User
Route::get('/users', 'UserController@index');
Route::get('/users/list', 'UserController@list');
Route::post('/users/create', 'UserController@create');
Route::post('/users/update', 'UserController@update');
Route::post('/users/destroy', 'UserController@destroy');
Route::post('/users/toggle-status', 'UserController@toggleStatus');

// Permissions
Route::get('/permissions', 'PermissionController@index');
Route::get('/permissions/list', 'PermissionController@list');
Route::post('/permissions/insert', 'PermissionController@insert');
Route::post('/permissions/update', 'PermissionController@update');
Route::post('/permissions/destroy', 'PermissionController@destroy');
Route::get('/permissions/roles/show', 'PermissionController@showRoles');
Route::get('/permissions/roles/list', 'PermissionController@listPermissionRoles');
Route::post('/permissions/roles/set', 'PermissionController@setRole');

// Roles
Route::get('/roles', 'RoleController@index');
Route::get('/roles/list', 'RoleController@list');
Route::post('/roles/insert', 'RoleController@insert');
Route::post('/roles/update', 'RoleController@update');
Route::post('/roles/destroy', 'RoleController@destroy');
Route::get('/roles/permissions/show', 'RoleController@showPermissions');
Route::get('/roles/permissions/list', 'RoleController@listRolePermissions');
Route::post('/roles/permissions/set', 'RoleController@setPermission');

// Agents
Route::get('/agents', 'AgentController@index');
Route::get('/agents/list', 'AgentController@list');
Route::get('/agents/list-agent-names', 'AgentController@listAgentNames');
Route::post('/agents/insert', 'AgentController@insert');
Route::post('/agents/update', 'AgentController@update');
Route::post('/agents/destroy', 'AgentController@destroy');


// Expenditures
Route::get('/expenditures','\App\Http\Controllers\ExpenditureController@index');
Route::get('/expenditures/list','\App\Http\Controllers\ExpenditureController@list');
Route::post('/expenditures/insert','\App\Http\Controllers\ExpenditureController@insert');
Route::post('/expenditures/update','\App\Http\Controllers\ExpenditureController@update');
Route::post('/expenditures/destroy','\App\Http\Controllers\ExpenditureController@destroy');
Route::get('/expenditures/list/types','\App\Http\Controllers\ExpenditureController@getTypeList');
Route::get('/expenditures/list/details','\App\Http\Controllers\ExpenditureController@getDetailList');

// Items
Route::get('/items', 'ItemController@index');
Route::get('/items/list', 'ItemController@list');
Route::get('/items/list-item-names/{fieldName}', 'ItemController@listItemNames');
Route::post('/items/insert', 'ItemController@insert');
Route::post('/items/update', 'ItemController@update');
Route::post('/items/destroy', 'ItemController@destroy');

// Imports
Route::get('/imports', 'ImportController@index');
Route::get('/imports/list', 'ImportController@list');
Route::post('/imports/create', 'ImportController@insert');
Route::post('/imports/update', 'ImportController@update');
Route::post('/imports/destroy', 'ImportController@destroy');


// Import Details
Route::get('/import-details', 'ImportDetailController@index');
Route::get('/import-details/list', 'ImportDetailController@list');
Route::post('/import-details/insert', 'ImportDetailController@insert');
Route::post('/import-details/update', 'ImportDetailController@update');
Route::post('/import-details/destroy', 'ImportDetailController@destroy');

// Exports
Route::get('/exports', 'ExportController@index');
Route::get('/exports/list', 'ExportController@list');
Route::post('/exports/insert', 'ExportController@insert');
Route::post('/exports/update', 'ExportController@update');
Route::post('/exports/destroy', 'ExportController@destroy');


// Export Details
Route::get('/export-details', 'ExportDetailController@index');
Route::get('/export-details/list', 'ExportDetailController@list');
Route::post('/export-details/insert', 'ExportDetailController@insert');
Route::post('/export-details/update', 'ExportDetailController@update');
Route::post('/export-details/destroy', 'ExportDetailController@destroy');

Route::match(['get', 'post'], 'should-be-an-agent', function(){
	return view('errors.should_be_an_agent');
});

Route::match(['get', 'post'], 'settings', function(){
	return view('settings.index');
});

// Export Details
Route::get('/activities', 'ActivityController@index');
Route::get('/activities/list', 'ActivityController@list');
Route::get('/activities/list/model-activity-name', 'ActivityController@listModelActivityNames');





