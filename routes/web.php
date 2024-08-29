<?php

use App\Http\Controllers\fileUploadController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users;
use App\Http\Middleware\CommonMiddleware;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/Home', 'Home')->name('Home')->middleware('middleware');
Route::view('/About', 'about')->name('About')->middleware(CommonMiddleware::class);
Route::view('/Form', 'form')->name('Form');

Route::get('/about', function () {
    return view('about');
});

Route::get('/firstPage/{var}', function ($var) {
    return view('firstPage', ['var' => $var]);
});

Route::get('/form', function () {
    $users = DB::select('SELECT * FROM users');
    return view('Form', [
        'users' => $users
    ]);
})->name('form');



// rout grouping
Route::prefix('users')->group(function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::controller(Users::class)->group(function(){
        Route::post('/addUser',  'addUser')->name('addUser');
        Route::get('/getUsersFromDb','getUsersFromDb');
        Route::put('/{id}', 'update')->name('users.update');
        Route::delete('/{id}','destroy')->name('users.destroy');
        Route::get('/{id}/edit','edit')->name('users.edit');
    });
});

// controller grouping
Route::controller(users::class)->group(function () {
    Route::get('/getUsers/{dynamicName}', 'getUsers');
    Route::get('getDataFromAPi', 'getDataFromAPi');
});

Route::view('/fileUpload','fileUpload')->name('fileUploadGet');
Route::post('/fileUpload',[fileUploadController::class,'fileUpload'])->name('fileUpload');

Route::prefix('student')->group(function(){
    Route::controller(StudentController::class)->group(function(){
        Route::get('/','Get_Student')->name('Get_Student');
        Route::post('/Add_Student','Add_Student')->name('Add_Student');
        Route::delete('/Delete_Student/{id}','Delete_Student')->name('Delete_Student');
        Route::post('/Edit_Student/{id}','Edit_Student')->name('Edit_Student');
        Route::put('/Update_Student/{id}','Update_Student')->name('Update_Student');
        Route::get('/search','search')->name('search');
        Route::post('/delete-multiple','deleteMultiple')->name('Delete_Multiple_Students');
    });
});

Route::get('/send-mail',[mail::class,'sendMail']);