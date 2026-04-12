<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReadingListController;
use App\Http\Controllers\AuthorSubmissionController;
use App\Http\Controllers\AdminSubmissionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminActivityLogController;

Route::get('/', function () {
	return redirect()->route('login.form');
});

Route::middleware('guest')->group(function () {
	Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
	Route::post('/register', [AuthController::class, 'register'])->name('register');
	Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
	Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])
	->middleware('auth')
	->name('logout');

Route::middleware('auth')->group(function () {
	Route::resource('books', BookController::class)->only(['index', 'show']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
	Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
	Route::get('/admin/activity-log', [AdminActivityLogController::class, 'index'])->name('admin.activity-log');

	Route::resource('books', BookController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);

	Route::get('/admin/submissions', [AdminSubmissionController::class, 'index'])->name('admin.submissions.index');
	Route::post('/admin/submissions/{submission}/approve', [AdminSubmissionController::class, 'approve'])->name('admin.submissions.approve');
	Route::post('/admin/submissions/{submission}/reject', [AdminSubmissionController::class, 'reject'])->name('admin.submissions.reject');
});

Route::middleware(['auth', 'role:customer,reader'])->group(function () {
	Route::post('/books/{book}/purchase', [PurchaseController::class, 'store'])->name('books.purchase');
	Route::post('/books/{book}/reading-list', [ReadingListController::class, 'store'])->name('books.reading-list');
});

Route::middleware(['auth', 'role:author'])->group(function () {
	Route::get('/author/submissions', [AuthorSubmissionController::class, 'index'])->name('author-submissions.index');
	Route::get('/author/submissions/create', [AuthorSubmissionController::class, 'create'])->name('author-submissions.create');
	Route::post('/author/submissions', [AuthorSubmissionController::class, 'store'])->name('author-submissions.store');
});