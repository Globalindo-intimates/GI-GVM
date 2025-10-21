<?php

use App\Http\Controllers\GeneralaffController;
use App\Http\Controllers\PerawatanController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('/');
})->middleware('auth', 'verified');

//Login
Route::resource('/', \App\Http\Controllers\AuthController::class);
Route::post('/auth/sign_in', [\App\Http\Controllers\AuthController::class, 'signIn']);
Route::post('/auth/sign_up', [\App\Http\Controllers\AuthController::class,'signUp']);
Route::get('/auth/sign_out', [\App\Http\Controllers\AuthController::class, 'signOut'])->name('logout');
Route::get('/auth/getQuote', [\App\Http\Controllers\AuthController::class, 'getQuote']);


Route::get('/dashboard', function () {
    return view('/');
})->middleware('auth', 'verified')->name('dashboard');

// Content
// Route::middleware('guest')->group(function () {

Route::get('/auth/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::get('/auth/create', [\App\Http\Controllers\AuthController::class, 'create']);
Route::get('/auth/login', [\App\Http\Controllers\AuthController::Class, 'loginlihat'])->name('login.lihat');
Route::post('/auth/in', [\App\Http\Controllers\AuthController::Class, 'loginSubmit'])->name('login.Submit');
Route::get('/auth/validate', [\App\Http\Controllers\AuthController::Class,'usernameValidate']);
// });

//ALL
Route::get('/dashboard', [\App\Http\Controllers\ContentController::class, 'dashboard'])->name('content.dashboard');
//Kendaraan
Route::get('/kendaraan', [\App\Http\Controllers\ContentController::class, 'dashboardkendaraan'])->name('content.kendaraan');
Route::post('/simpan', [\App\Http\Controllers\DataController::Class, 'store'])->name('data.store');
Route::get('/check-existing-data', [\App\Http\Controllers\DataController::class, 'checkExistingData']);

//LihatData
Route::get('/lihatdata/{id}', [\App\Http\Controllers\ContentController::class, 'dashboarddata'])->name('content.lihatdata');
Route::get('/data', [\App\Http\Controllers\ContentController::class,'dashboardform'])->name('content.form');


//GA
Route::get('/dashboardGA', [\App\Http\Controllers\ContentController::class, 'dashboardGA'])->name('content.dashboardGA');
Route::get('/dataperawatan', [\App\Http\Controllers\ContentController::class,'dataperawatan'])->name('content.dataperawatan');
Route::get('/infodata', [\App\Http\Controllers\ContentController::class,'infodata'])->name('content.infodata');
Route::get('/getdata', [\App\Http\Controllers\ContentController::class,'getData']);
Route::get('/getmasterdata', [\App\Http\Controllers\ContentController::class,'getMasterdata']);
Route::post('/simpanajax', [\App\Http\Controllers\ContentController::class,'simpanAjax']);
Route::put('/{id}/status', [\App\Http\Controllers\GeneralaffController::class,'update'])->name('data.update');
Route::delete('/{id}/delete', [\App\Http\Controllers\GeneralaffController::class,'destroy'])->name('data.delete');
Route::get('/ga/detail/{id}', [\App\Http\Controllers\GeneralaffController::class,'detailData']);
Route::get('/print/{id}', [\App\Http\Controllers\GeneralaffController::class,'print'])->name('GA.print');
// Di routes/web.php

//MASTERDATA
Route::post('/simpandata', [App\Http\Controllers\MasterController::class, 'store'])->name('master.store');
Route::put('/update/{id}', [\App\Http\Controllers\MasterController::class,'update'])->name('master.update');
Route::delete('/delete/{id}', [\App\Http\Controllers\MasterController::class,'destroy'])->name('master.delete');
Route::get('/tersimpan', [App\Http\Controllers\DataController::class,'getKendaraan'])->name('master.tersimpan');

// USER
Route::post('/simpanuser', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
Route::put('/updateuser/{id}', [\App\Http\Controllers\UserController::class,'update'])->name('user.update');
Route::delete('/deleteuser/{id}', [\App\Http\Controllers\UserController::class,'destroy'])->name('user.delete');

// ADMIN
Route::get('/dashboardAdmin', [\App\Http\Controllers\ContentController::class, 'dashboardAdmin'])->name('content.dashboardAdmin');
Route::get('/masterdata', [\App\Http\Controllers\ContentController::class,'master'])->name('content.master');
Route::get('/user', [\App\Http\Controllers\ContentController::class,'user'])->name('content.user');
//Route::post('/dashboard', [\App\Http\Controllers\ContentController::class, 'dashboard'])->name('content.dashboard');
