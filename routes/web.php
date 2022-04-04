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

use App\Http\Controllers\AjaxCOMMENTCRUDController;
Route::get('ajax-comment-crud', [AjaxCOMMENTCRUDController::class, 'index']);
Route::post('save-comment', [AjaxCOMMENTCRUDController::class, 'store']);
Route::get('fetch-comments', [AjaxCOMMENTCRUDController::class, 'fetchComments']);
Route::get('edit-comment/{id}', [AjaxCOMMENTCRUDController::class, 'edit']);
Route::put('update-comment/{id}', [AjaxCOMMENTCRUDController::class, 'update']);
Route::delete('delete-comment/{id}', [AjaxCOMMENTCRUDController::class, 'destroy']);


Route::get('/', function () {
    return view('welcome');
});
