<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\EmployeeController;
use App\Services\RabbitMQService;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts',PostController::class);
Route::resource('employees',EmployeeController::class);
Route::get('/search', [EmployeeController::class, 'search'])->name('employees.search');

Route::post('/publish-message', function(Request $request) {
    $data = $request->all();
    $rabbitMQService = new RabbitMQService();
    $message = json_encode($data);
    $rabbitMQService->publish($message);

    return response()->json(['message' => 'Message published to RabbitMQ']);
});