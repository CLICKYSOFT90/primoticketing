<?php

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

Route::get('/', 'Frontend\Home\ManageHomeController@index')->name('front');
Route::get('/home', 'Frontend\Home\ManageHomeController@index')->name('front');
Route::get('webhookServiceAddress',function(){
    \App\Models\Address::syncAddresses();
    dd("synced");
});
Route::post('webhookServiceAddress',function(){
    \App\Models\Address::syncAddresses();
    dd("synced");
})->name('webhookServiceAddress');

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Admin\Auth\LoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

    // Password Reset Routes...
    Route::get('password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('admin.password.verify');

});

Route::middleware(['auth:admin'])->prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/{url?}', 'Dashboard\ManageDashboardController@index')->where('url','dashboard|')->name('admin.dashboard');
    //Route::get('dashboard', 'Dashboard\ManageDashboardController@index')->name('dashboard');
    //Route::get('home', 'Dashboard\ManageDashboardController@index');
    //Route::post('dashboard', 'Dashboard\ManageDashboardController@index')->name('dashboard');
    Route::post('select2Ajax', function() { Common::select2Ajax(); })->name('select2Ajax');
});
Route::middleware(['auth:admin', 'permissions'])->namespace('Admin')->prefix('admin')->group(function () {
    Route::resource('users', 'Users\ManageUsersController');
    Route::resource('configuration', 'Configuration\ManageConfigurationController');
    Route::resource('roles', 'Users\RolesController');
    Route::match(['put', 'patch'], 'roles/permissions/assign/{role}', 'Users\RolesController@assignPermission')->name('roles.assignPermission');
    Route::resource('flagtype', 'FlagType\ManageFlagTypeController');
    Route::resource('flag', 'Flag\ManageFlagController');
    Route::post('flag/child','Flag\ManageFlagController@getFlagChild')->name('flag.child');
    Route::resource('cronJob', 'CronJob\ManageCronJobController');
    Route::get('sample/{model}', 'File\ManageFileController@sample')->name('sample');
    Route::post('import/{model}', 'File\ManageFileController@import')->name('import');
    Route::get('export/{model}', 'File\ManageFileController@export')->name('export');
    Route::get('download/{model}', 'File\ManageFileController@download')->name('download');
    Route::resource('menu', 'Menu\ManageMenuController');
    Route::resource('notification', 'Notification\ManageNotificationController');
    Route::resource('organization', 'Organization\ManageOrganizationController');
    Route::resource('globalSetting', 'GlobalSetting\ManageGlobalSettingController');

    /*Change Password*/
    Route::get('changePassword', 'Users\ChangePasswordController@index')->middleware('auth')->name('change-password');
    Route::post('changePassword', 'Users\ChangePasswordController@store')->middleware('auth')->name('update-password');
    /**/
});

Route::group([
    'namespace' => 'Auth',
], function () {

    // Authentication Routes...
    Route::get('login', 'WebsiteLoginController@showLoginForm')->name('login_page');
    Route::post('login', 'WebsiteLoginController@login')->name('login');
    Route::get('logout', 'WebsiteLoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register_page');
    Route::post('register', 'RegisterController@register')->name('register');
    Route::get('register/activate/{token}', 'RegisterController@confirm')->name('email_confirm');

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

});
Route::middleware(['auth:web'])->group(function () {
    Route::get('cart', 'Frontend\Cart\ManageCartController@index')->name('cart');
    Route::get('add-to-cart/{id}', 'Frontend\Cart\ManageCartController@addToCart')->name('add.to.cart');
    Route::patch('update-cart', 'Frontend\Cart\ManageCartController@update')->name('update.cart');
    Route::delete('remove-from-cart', 'Frontend\Cart\ManageCartController@remove')->name('remove.from.cart');
    Route::get('checkout', 'Frontend\Cart\ManageCartController@checkout')->name('checkout');
    Route::post('payment', 'Frontend\Cart\ManageCartController@payment')->name('payment');
    Route::get('myaccount', 'Frontend\MyAccount\ManageMyAccountController@index')->name('myaccount');
    Route::post('delete-service', 'Frontend\MyAccount\ManageMyAccountController@removeService')->name('remove.service');


});
/*API*/
Route::post('API', 'API\ManageAPIController@index');


Route::get('migrate',function(){
    Artisan::call('migrate');
    dd("migrated");
});
Route::get('freshmigrate',function(){
    Artisan::call('migrate:fresh --seed');
});
/**/


