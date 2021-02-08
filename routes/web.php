<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

Route::view('/', 'welcome');

Route::view('upload', 'upload');
Route::post('/upload', [SaleController::class, 'upload']);
Route::get('/batch', [SaleController::class, 'batch']);