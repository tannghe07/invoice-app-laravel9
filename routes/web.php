<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\CustomerController;

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

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [InvoiceController::class, 'dashboard'])->name('dashboard');
    
    // Invoices
    Route::get('/invoices/data', [InvoiceController::class, 'getInvoices'])->name('invoices.data');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::put('/invoices/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    Route::get('/customers', [InvoiceController::class, 'getCustomers'])->name('customers.list');
    
    // Revenue
    Route::get('/revenue', [RevenueController::class, 'dashboard'])->name('revenue.dashboard');
    Route::get('/revenue/data', [RevenueController::class, 'getData'])->name('revenue.data');
    Route::get('/revenue/summary', [RevenueController::class, 'getSummary'])->name('revenue.summary');
    
    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/check-phone', [CustomerController::class, 'checkPhone'])->name('customers.check-phone');
    Route::get('/customers/data', [CustomerController::class, 'getData'])->name('customers.data');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});
