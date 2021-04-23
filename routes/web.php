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
Route::get('/storagess', function () {
    Artisan::call('storage:link');
    return "yooo";
});
Route::get('/', function () {
    // return url('/login');
    return redirect()->route('login');
});

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::post('login-dashboard','AdminController@loginDashboard')->name('login-dashboard');
Route::get('dashboard','AdminController@index')->name('dashboard');
Route::get('category-actions','AdminController@categoryActions')->name('category-actions');
Route::get('brand-actions','AdminController@brandActions')->name('brand-actions');
Route::get('trending-products','AdminController@trendingProdects')->name('trending-products');
Route::get('products-actions','AdminController@getProdects')->name('products-actions');
Route::get('promocode','AdminController@promoCode')->name('promocode');
Route::get('app-users','AdminController@appUsers')->name('app-users');
Route::get('deliveries','AdminController@deliveries')->name('deliveries');
Route::post('/import-file',['as'=>'import-file',   'uses'=>'AdminController@import']);


