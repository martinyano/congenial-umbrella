<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\UserContoller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome'])->name('guest.welcome');

Route::get('/kiosk', [KioskController::class, 'index'])->name('kiosk.index');
Route::post('/kiosk/scan', [KioskController::class, 'processScan'])->name('kiosk.scan');
Route::get('catalog/books/{book}', [BookController::class, 'publicShow'])->name('books.public_show');
Route::get('catalog/books', [BookController::class, 'userIndex'])->name('books.index');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Single unified dashboard route that handles both Admins and Students
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // 1. Send admins to their admin panel
        if ($user && $user->usertype === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Pass the request forward so filtering works
        return app(DashboardController::class)->index();

    })->name('dashboard');
    Route::get('/admin/dashboard', [AdminTransactionController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('books', BookController::class)->names('admin.books');
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/authors', [AuthorController::class, 'index'])->name('admin.authors.index');
    Route::get('/users', [UserContoller::class, 'index'])->name('admin.users.index');
    Route::get('/borrow/create', [BorrowController::class, 'create'])->name('borrow.create');
    Route::post('/borrow', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('admin.inventory');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{book}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{book}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    // Admin Transactions Page
    Route::get('/admin/transactions', [AdminTransactionController::class, 'transactions'])
        ->name('admin.transactions');

    // Admin Borrow Action Handlers
    Route::post('/admin/borrows/{borrow}/approve', [AdminTransactionController::class, 'approve'])
        ->name('admin.borrows.approve');

    Route::post('/admin/borrows/{borrow}/deny', [AdminTransactionController::class, 'deny'])
        ->name('admin.borrows.deny');

    Route::post('/admin/borrows/{borrow}/return', [AdminTransactionController::class, 'returnBook'])
        ->name('admin.borrows.return');

    Route::resource('categories', CategoryController::class)->names([
        'index'   => 'admin.categories.index',
        'create'  => 'admin.categories.create',
        'store'   => 'admin.categories.store',
        'show'    => 'admin.categories.show',
        'edit'    => 'admin.categories.edit',
        'update'  => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    Route::resource('authors', AuthorController::class)->names([
        'index'   => 'admin.authors.index',
        'create'  => 'admin.authors.create',
        'store'   => 'admin.authors.store',
        'show'    => 'admin.authors.show',
        'edit'    => 'admin.authors.edit',
        'update'  => 'admin.authors.update',
        'destroy' => 'admin.authors.destroy',
    ]);

    Route::resource('users', UserContoller::class)->names([
        'index'   => 'admin.users.index',
        'create'  => 'admin.users.create',
        'store'   => 'admin.users.store',
        'show'    => 'admin.users.show',
        'edit'    => 'admin.users.edit',
        'update'  => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
});

Route::get('/home', [AdminController::class, 'index']);

