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

/*
 *  All /admin routes
 */
Route::group(['prefix' => 'admin'], function() {

    /*
     * Authenticated routes
     */
    Route::group(['middleware' => 'auth'], function(){
        Route::get('/',function(){
            return Redirect::to('admin/dashboard');
        });
        Route::resource('dashboard', '\App\Admin\Http\Controllers\DashboardController');
        Route::group(['middleware' => 'role'], function(){
            //>>CMS
            Route::resource('recipes', '\App\Admin\Http\Controllers\RecipeController');
            Route::resource('menus', '\App\Admin\Http\Controllers\MenuController');
            Route::resource('tests', '\App\Admin\Http\Controllers\TestController');
            Route::resource('menus.menu_items', '\App\Admin\Http\Controllers\MenuItemController');
            Route::resource('tests.test_items', '\App\Admin\Http\Controllers\TestItemController');
            Route::resource('roles', '\App\Admin\Http\Controllers\RoleController');
            Route::resource('settings', '\App\Admin\Http\Controllers\SettingController');
            Route::resource('configurations', '\App\Admin\Http\Controllers\ConfigurationController');
            Route::resource('users', '\App\Admin\Http\Controllers\UserController');
            //<<CMS
        });
        //Ajax request
        $model = studly_case(str_singular(Request::segment(2)));
        Route::post('{module}/ajax', array('as' => 'ajaxRequest', 'uses' => '\App\Admin\Http\Controllers\\'.$model.'Controller@ajax'))->where('module','.+');

    });

    // Authentication Routes...
        $this->get('login', '\App\Admin\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
        $this->post('login', '\App\Admin\Http\Controllers\Auth\LoginController@login');
        $this->get('logout', '\App\Admin\Http\Controllers\Auth\LoginController@logout')->name('logout');

    // Registration Routes...
        $this->get('register', '\App\Admin\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
        $this->post('register', '\App\Admin\Http\Controllers\Auth\RegisterController@register');

    // Password Reset Routes...
        $this->get('password/reset', '\App\Admin\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm');
        $this->post('password/email', '\App\Admin\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
        $this->get('password/reset/{token}', '\App\Admin\Http\Controllers\Auth\ResetPasswordController@showResetForm');
        $this->post('password/reset', '\App\Admin\Http\Controllers\Auth\ResetPasswordController@reset');
});


Route::get('/home', 'HomeController@index');
