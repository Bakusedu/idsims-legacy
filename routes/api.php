<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DrugController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// create a user
Route::post('user',[UserController::class, 'store']);
// view a user profile
Route::get('user/{user_id}',[UserController::class, 'show'])->middleware('auth:api');
// update a user
Route::put('user/{user_id}',[UserController::class, 'update'])->middleware('auth:api');
// delete a user
Route::delete('user/{user_id}',[UserController::class, 'destroy'])->middleware('auth:api');
// get all users
Route::get('/users',[UserController::class, 'index'])->middleware('auth:api');
// login user
Route::post('/login',[UserController::class, 'login'])->name('login');
// create a customer
Route::post('/customer',[CustomerController::class, 'store']);
// create a vendor
Route::post('/vendor',[VendorController::class, 'store']);
// create a drug
Route::post('/drug',[DrugController::class, 'store'])->middleware('auth:api');
// update a drug
Route::patch('/drug/{drug_id}',[DrugController::class, 'update'])->middleware('auth:api');
// get all drugs
Route::get('/drug',[DrugController::class, 'index'])->middleware('auth:api');
// show single drug
Route::get('/drug/{id}',[DrugController::class, 'show'])->middleware('auth:api');
// delete a drug
Route::delete('/drug/{drug_id}',[DrugController::class, 'destroy'])->middleware('auth:api');
// Search for anything related to a drug table
Route::get('/search',[VendorController::class, 'search'])->middleware('auth:api');
// get Customer drug history
Route::get('/customer/{phone}', [UserController::class, 'customerDrugHistory'])->middleware('auth:api');
// add a new purchase
Route::post('/purchase', [UserController::class, 'purchase'])->middleware('auth:api');
// get vendor drug purchase
Route::get('/drug_purchase/{id}',[UserController::class, 'getDrugPurchase'])->middleware('auth:api');
// get health information data through purchases made by customer
Route::get('/health_information/{customer_id}',[CustomerController::class, 'healthInformation'])->middleware('auth:api');
// post vendor settings
Route::post('/vendor_settings',[VendorController::class, 'upload'])->middleware('auth:api');
// get vendor settings
Route::get('/vendor_settings',[VendorController::class, 'getSettings'])->middleware('auth:api');
// get all vendors registered in the db
Route::get('/vendors', [UserController::class, 'vendors'])->middleware('auth:api');
// get all customers registered in the db
Route::get('/customers', [UserController::class, 'customers'])->middleware('auth:api');
// get vendors sold drugs
Route::get('/vendor_purchases/{vendor_id}',[UserController::class, 'allVendorPurchase'])->middleware('auth:api');
// get vendors sold drugs
Route::get('/vendor_purchase_frequency/{vendor_id}',[UserController::class, 'vendorFrequency'])->middleware('auth:api');
// toggle Vendor activation status
Route::get('/toggle_status/{vendor_id}',[UserController::class, 'toggleActivation'])->middleware('auth:api');
// Route to get all the systems registered vendors
Route::get('/registered_vendors',[UserController::class, 'registeredVendors']);
// Route to get registered vendors drugs
Route::get('/registered_vendors/{vendor_id}',[UserController::class, 'getVendorDrugs']);
// Route to view a drug on home page
Route::get('/view_drug/{drug_id}',[UserController::class, 'viewDrug']);
// Route to get searched drugs, their prices, store name and address
Route::get('/compare_drug/{drug_name}',[CustomerController::class, 'compareDrug'])->middleware('auth:api');
// Route to logout of the application and revoke token
Route::get('/logout',[UserController::class, 'logout'])->middleware('auth:api');
