<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\AdminController;

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

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Autentikasi Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', function () {
    return redirect()->route('home');
})->name('home');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Registrasi Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Verifikasi Email Routes
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// Post Routes
Route::resource('posts', PostController::class);

// Comment Routes
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

// Protected Routes (memerlukan autentikasi)
Route::middleware(['auth'])->group(function () {
    // Tambahkan rute yang memerlukan autentikasi di sini
    // Contoh:
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Protected Routes (memerlukan autentikasi dan verifikasi email)
Route::middleware(['auth', 'verified'])->group(function () {
    // Tambahkan rute yang memerlukan autentikasi dan verifikasi email di sini
    // Contoh:
    // Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});
// Grup rute untuk admin dengan middleware auth dan role admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/posts', [AdminController::class, 'posts'])->name('admin.posts');
    
    // Rute untuk mengelola pengguna
    Route::post('/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::put('/users/{user}/suspend', [AdminController::class, 'suspendUser'])->name('admin.users.suspend');
    Route::put('/users/{user}/activate', [AdminController::class, 'activateUser'])->name('admin.users.activate');
    
    // Rute untuk mengelola postingan
    Route::put('/posts/{post}/suspend', [AdminController::class, 'suspendPost'])->name('admin.posts.suspend');
    Route::put('/posts/{post}/activate', [AdminController::class, 'activatePost'])->name('admin.posts.activate');

    // Rute toggle suspension
    Route::post('/user/{user}/toggle-suspension', [AdminController::class, 'toggleUserSuspension'])->name('admin.user.toggle-suspension');
    Route::post('/post/{post}/toggle-suspension', [AdminController::class, 'togglePostSuspension'])->name('admin.post.toggle-suspension');
    
    // Rute untuk membuat dan menyimpan postingan baru
    Route::get('/posts/create', [AdminController::class, 'createPost'])->name('admin.posts.create');
    Route::post('/posts', [AdminController::class, 'storePost'])->name('admin.posts.store');
    
    // Rute untuk menampilkan detail postingan
    Route::get('/posts/{post}', [AdminController::class, 'showPost'])->name('admin.posts.show');
    
    // Rute untuk mengedit dan memperbarui postingan
    Route::get('/posts/{post}/edit', [AdminController::class, 'editPost'])->name('admin.posts.edit');
    Route::put('/posts/{post}', [AdminController::class, 'updatePost'])->name('admin.posts.update');
});