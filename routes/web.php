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
    return view('home');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
  ]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'HomeController@logout');

Route::group(['middleware' => 'web'], function(){
    // View Routes
    Route::get('/', ['as' => 'index', 'uses' => 'GeneralController@index']);
    Route::get('roles', ['as' => 'roles', 'uses' => 'GeneralController@rolesView']);
    Route::get('users', ['as' => 'users', 'uses' => 'GeneralController@usersView']);
    Route::get('categories', ['as' => 'categories', 'uses' => 'GeneralController@categoriesView']);
    Route::get('expenses', ['as' => 'expenses', 'uses' => 'GeneralController@expensesView']);

    // Axios Routes
    Route::get('fetch_roles', 'GeneralController@fetchRoles');
    Route::post('add_role', 'GeneralController@addRole');
    Route::patch('update_role', 'GeneralController@updateRole');
    Route::delete('delete_role/{id}', 'GeneralController@deleteRole');
    Route::get('fetch_users', 'GeneralController@fetchUsers');
    Route::post('add_user', 'GeneralController@addUser');
    Route::patch('update_user', 'GeneralController@updateUser');
    Route::delete('delete_user/{id}', 'GeneralController@deleteUser');
    Route::get('fetch_categories', 'GeneralController@fetchCategories');
    Route::post('add_category', 'GeneralController@addCategory');
    Route::patch('update_category', 'GeneralController@updateCategory');
    Route::delete('delete_category/{id}', 'GeneralController@deleteCategory');
    Route::get('fetch_expenses', 'GeneralController@fetchExpenses');
    Route::post('add_expense', 'GeneralController@addExpense');
    Route::patch('update_expense', 'GeneralController@updateExpense');
    Route::delete('delete_expense/{id}', 'GeneralController@deleteExpense');
    
    Route::get('helper_fetch_role', 'GeneralController@fetchHelperRoles');
    Route::get('helper_fetch_categories', 'GeneralController@fetchHelperCategories');
    Route::get('dashbaord_data', 'GeneralController@fetchDashboardData');
});
