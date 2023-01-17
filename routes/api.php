<?php

use Illuminate\Http\Request;
use App\Http\Controllers\payments\mpesa\MpesaTransactionsController;

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

Route::post('/get-token', [MpesaTransactionsController::class, 'generateAccessToken'])->name('generateAccessToken');

Route::post('/mpesa-stkPush', [MpesaTransactionsController::class, 'stkPush'])->name('stkPush');


Route::get('/Mpesa-payment/responses',[MpesaResponsesController::class, 'stkResponseMsg'])->name('stkResponseMsg');


Route::get('/responses', [MpesaTransactionsController::class, 'mpesaRes'])->name('mpesaRes');