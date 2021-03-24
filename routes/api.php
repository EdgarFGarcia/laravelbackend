<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DispatchInvitation;
use App\Http\Controllers\ApiController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/sendinvitation', [DispatchInvitation::class, 'dispatchinvitation']);
Route::get('/getusers', [ApiController::class, 'getusers']);
Route::get('/edituser/{id}', [ApiController::class, 'edituser']);
Route::post('/editinformation', [ApiController::class, 'editinformation']);
Route::get('/sendwelcomemessage', [DispatchInvitation::class, 'sendwelcomemessage']);
Route::post('/deleteuser', [ApiController::class, 'deleteuser']);