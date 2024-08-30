<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => "auth:sanctum"], function () {
    Route::post('Add_Student', [StudentController::class,'Add_Student_Api']);
    Route::get('Get_Student', [StudentController::class,'Get_Student_Api']);
    Route::patch('Update_Student/{id}', [StudentController::class,'Update_Student_Api']);
    Route::delete('Delete_Student/{id}', [StudentController::class,'Delete_Student_Api']);
});

Route::post('signUp',[AuthController::class,'signUp']);
Route::post('login',[AuthController::class,'login']);
Route::get('login',[AuthController::class,'loginError'])->name('login');

Route::post('testWithPost',function(Request $req){
    return $req;
});