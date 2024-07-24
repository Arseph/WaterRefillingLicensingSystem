<?php

use App\Http\Controllers\AlertNotification;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\UploadFileController;
use App\Models\User;
use App\Models\Client;
use App\Mail\SampleEmail;
use Illuminate\Support\Facades\DB;
use App\Models\InitialApplications;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\SampleInspectorController;

Route::get('/', function () {
    return view('login');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'register')->name('register');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'login')->name('login');
});


Route::get('/welcome', function () {
    return view('welcome');
});

// Route::get('/inspector', [InspectorController::class, 'index']);

// Route::get('/getapps', [InspectorController::class, 'index']);

//View Inspector page
Route::get('/inspector', function () {
    return view('inspector');
});

//Retrieve data from controller to display on the DataTables in Inspector page
Route::get('/initapps', [InspectorController::class, 'initapps']);
Route::get('/opapps', [InspectorController::class, 'opapps']);

//Perform update on 1 row of facility record in the Inspector Page for Initial Applications
Route::put('set-initapp-inspection/{id}', [InspectorController::class, 'setInitAppInspection']);

//Get the initial attachment based on the initial application's id
Route::get('get-init-attachment/{id}', [AttachmentController::class, 'getInitAttachment']);

//Example only
Route::get('/sample', [SampleInspectorController::class, 'index']);


//Mail sending route
Route::post('/send-email', [EmailController::class, 'sendEmail']);

//Alert notification route
Route::get('/get-alerts', [AlertNotification::class, 'getAlerts']);

//Route for testing uploading file features
Route::get('/uploadfile', [UploadFileController::class, 'upload']);
Route::post('/uploadfile', [UploadFileController::class, 'uploadPost']);

//Route for testing viewing upload files features
Route::post('/viewtestfile', [AttachmentController::class, 'viewInitAttachment']);

// Route::get('/viewtestfile', function(){
//     return view('/testing/viewtestfile');
// });

// Route::get('/send-email', function(){
//     Mail::to('recipient@example.com')->send(new SampleEmail());
//     return "Email sent successfully";
// });

// Route::get('/pizzas', function(){

//     $pizzas = [
//         ['type'=> 'hawaiian', 'base'=>'cheesy crust'],
//         ['type'=> 'volcano', 'base'=>'garlic crust'],
//         ['type'=> 'veg supreme', 'base'=>'thin & crispy']
//     ];

//     return view('pizzas', ['pizzas'=> $pizzas]);
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
