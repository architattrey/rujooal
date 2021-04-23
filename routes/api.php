<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login','ApiController@login');
Route::get('/get-all-states','ApiController@getAllStates');
Route::post('/get-all-cities','ApiController@getAllCities');
Route::post('/update-user-profile','ApiController@appUserProfileUpdate');
Route::post('/upload-image','ApiController@imageUpload');
Route::post('/update-firebase-token','ApiController@updateFireBaseToken');
Route::post('/get-all-categories','ApiController@getAllCategories');
Route::post('/get-all-products','ApiController@getAllProducts');
Route::post('/get-product-weights','ApiController@getAllWeightOfProduct');
Route::post('/add-to-cart','ApiController@addToCart');
Route::post('/view-cart','ApiController@viewCartOfUser');
Route::post('/get-single-product','ApiController@getSingleProduct');

Route::post('/delete-cart-product','ApiController@deleteProductFromCart');
Route::post('/add-delivery-address','ApiController@AddUsersDeliveryAddress');
Route::post('/get-delivery-address','ApiController@getDeliveryAddress');
Route::post('/add-feedback','ApiController@addFeedbacks');
Route::post('/addition-of-amounts','ApiController@additionOfAmount');
Route::get('/get-trending-products','ApiController@trendingProducts');
Route::get('/get-users-feedbacks','ApiController@getUsersFeedback');
Route::post('/delete-delivery-address','ApiController@deleteDeliveryAddress');
Route::post('/submit-transaction','ApiController@submitTransaction');
Route::get('/all-promocodes','ApiController@allPromocodes');
Route::post('/old-transactions','ApiController@oldTransactions');
Route::post('/apply-promocode','ApiController@applyPromoCode');
Route::post('/get-delivery-status','ApiController@getDeliveryStatus');
Route::post('/banner-descount-products','ApiController@getDescountProducts');
Route::post('/add-user-referal-code','ApiController@addReferalCode');
Route::post('/add-redemeed-data','ApiController@addRedemeedData');
Route::post('/get-wallet-data','ApiController@getAllWalletAmount');