<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;

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
    Route::post('/invoices/{id}/restore', [InvoiceController::class, 'restore'])->name('invoices.restore');

    Route::get('/customers', [InvoiceController::class, 'getCustomers'])->name('customers.list');

    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/check-phone', [CustomerController::class, 'checkPhone'])->name('customers.check-phone');
    Route::get('/customers/data', [CustomerController::class, 'getData'])->name('customers.data');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::post('/customers/{id}/restore', [CustomerController::class, 'restore'])->name('customers.restore');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/data', [TransactionController::class, 'getData'])->name('transactions.data');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Products (Inventory)
    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/data', [App\Http\Controllers\ProductController::class, 'getData'])->name('products.data');
    Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{id}/return', [App\Http\Controllers\ProductController::class, 'returnProduct'])->name('products.return');

    // Product Returns
    Route::get('/returns', [App\Http\Controllers\ProductReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/data', [App\Http\Controllers\ProductReturnController::class, 'getData'])->name('returns.data');
    Route::post('/returns', [App\Http\Controllers\ProductReturnController::class, 'store'])->name('returns.store');
    Route::get('/returns/{id}', [App\Http\Controllers\ProductReturnController::class, 'show'])->name('returns.show');
    Route::put('/returns/{id}', [App\Http\Controllers\ProductReturnController::class, 'update'])->name('returns.update');
    Route::delete('/returns/{id}', [App\Http\Controllers\ProductReturnController::class, 'destroy'])->name('returns.destroy');
});
