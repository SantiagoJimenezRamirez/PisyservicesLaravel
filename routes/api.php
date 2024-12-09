<?php

// routes/api.php
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json(['message' => 'API is running']);
});

Route::resource('user', UserController::class);
Route::resource('session', SessionController::class);
Route::resource('products', ProductController::class);
Route::resource('category', CategoryController::class);
Route::resource('service-requests', ServiceRequestController::class);

Route::prefix('user')->group(function () {
    Route::post('/create', [UserController::class, 'createUser']);
    Route::post('/login', [UserController::class, 'login']);
});


Route::prefix('session')->group(function () {
    Route::post('/', [SessionController::class, 'add']); 
    Route::get('/', [SessionController::class, 'getAll']);
});



Route::prefix('products')->group(function () {
    Route::post('/', [ProductController::class, 'add']);
    Route::get('/', [ProductController::class, 'getAll']);
    Route::get('/getAll', [ProductController::class, 'getAllWithImg']);
    Route::get('{id}', [ProductController::class, 'getById']);
    Route::put('{id}', [ProductController::class, 'update']);
    Route::delete('{id}', [ProductController::class, 'delete']);
});

Route::prefix('requests')->group(function () {
    Route::get('/', [RequestController::class, 'index']); // List all requests
    Route::post('/', [RequestController::class, 'store']); // Create a new request
    Route::get('{id}', [RequestController::class, 'show']); // Get a single request by ID
    Route::put('{id}', [RequestController::class, 'update']); // Update a request by ID
    Route::delete('{id}', [RequestController::class, 'destroy']); // Delete a request by ID
});


Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'getAll']);
    Route::post('/', [CategoryController::class, 'add']);
    Route::get('{id}', [CategoryController::class, 'getById']);
    Route::put('{id}', [CategoryController::class, 'update']);
    Route::delete('{id}', [CategoryController::class, 'delete']);
});


Route::prefix('requests')->group(function () {
    Route::post('/', [RequestController::class, 'store']); // Cambiamos 'add' por 'store'
    Route::get('/', [RequestController::class, 'index']);
    Route::get('{id}', [RequestController::class, 'show']);
    Route::put('{id}', [RequestController::class, 'update']);
    Route::delete('{id}', [RequestController::class, 'destroy']);
});
