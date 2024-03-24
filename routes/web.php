<?php

use Illuminate\Support\Facades\Route;

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

// Route untuk halaman login jika pengguna belum login
Route::get('/', function () {
    return \Inertia\Inertia::render('Auth/Login');
})->middleware('guest');

// Route login
Route::post('/login', [App\Http\Controllers\Login::class, 'store'])->middleware('guest');

//middleware "auth"
Route::group(['middleware' => ['auth']], function () {

    //route dashboard
    Route::get('dashboard', App\Http\Controllers\Dashboard::class)->name('dashboard');

    Route::post('/logout', [App\Http\Controllers\Login::class, 'destroy']);

    //route permissions
    Route::get('/permissions', \App\Http\Controllers\Permissions::class)->name('permissions.index')
        ->middleware('permission:permissions.index');

    //route resource roles
    Route::resource('/roles', \App\Http\Controllers\Roles::class)
        ->middleware('permission:roles.index|roles.create|roles.edit|roles.delete');

    Route::get('/users', [\App\Http\Controllers\Users::class, 'index'])->middleware('permission:users.index')->name('users.index');

    //route resource users
    Route::resource('/users', \App\Http\Controllers\Users::class)
        ->middleware('permission:users.index|users.create|users.edit|users.delete');

    Route::get('/categories', [\App\Http\Controllers\Categories::class, 'index'])->middleware('permission:categories.index')->name('categories.index');

    //route resource categories
    Route::resource('/categories', \App\Http\Controllers\Categories::class)
        ->middleware('permission:categories.index|categories.create|categories.edit|categories.delete');

    Route::get('/products', [\App\Http\Controllers\Products::class, 'index'])->middleware('permission:products.index')->name('products.index');

    //route resource products
    Route::resource('/products', \App\Http\Controllers\Products::class)
        ->middleware('permission:products.index|products.create|products.edit|products.delete');

    Route::get('/customers', [\App\Http\Controllers\Customers::class, 'index'])->middleware('permission:customers.index')->name('customers.index');

    //route resource customers
    Route::resource('/customers', \App\Http\Controllers\Customers::class)
        ->middleware('permission:customers.index|customers.create|customers.edit|customers.delete');

    //route transaction
    Route::get('/transactions', [\App\Http\Controllers\Transactions::class, 'index'])->middleware('permission:transactions.index')->name('transactions.index');

    //route transaction searchProduct
    Route::post('/transactions/searchProduct', [\App\Http\Controllers\Transactions::class, 'searchProduct'])->name('transactions.searchProduct');

    //route transaction addToCart
    Route::post('/transactions/addToCart', [\App\Http\Controllers\Transactions::class, 'addToCart'])->name('transactions.addToCart');

    //route transaction destroyCart
    Route::post('/transactions/destroyCart', [\App\Http\Controllers\Transactions::class, 'destroyCart'])->name('transactions.destroyCart');

    //route transaction store
    Route::post('/transactions/store', [\App\Http\Controllers\Transactions::class, 'store'])->name('transactions.store');

    //route transaction print
    Route::get('/transactions/print', [\App\Http\Controllers\Transactions::class, 'print'])->name('transactions.print');

    //route sales index
    Route::get('/sales', [\App\Http\Controllers\Sales::class, 'index'])->middleware('permission:sales.index')->name('sales.index');

    //route sales filter
    Route::get('/sales/filter', [\App\Http\Controllers\Sales::class, 'filter'])->name('sales.filter');

    //route sales export excel
    Route::get('/sales/export', [\App\Http\Controllers\Sales::class, 'export'])->name('sales.export');

    //route sales print pdf
    Route::get('/sales/pdf', [\App\Http\Controllers\Sales::class, 'pdf'])->name('sales.pdf');

    //route profits index
    Route::get('/profits', [\App\Http\Controllers\Profits::class, 'index'])->middleware('permission:profits.index')->name('profits.index');

    //route profits filter
    Route::get('/profits/filter', [\App\Http\Controllers\Profits::class, 'filter'])->name('profits.filter');

    //route profits export
    Route::get('/profits/export', [\App\Http\Controllers\Profits::class, 'export'])->name('profits.export');

    //route profits pdf
    Route::get('/profits/pdf', [\App\Http\Controllers\Profits::class, 'pdf'])->name('profits.pdf');
});
