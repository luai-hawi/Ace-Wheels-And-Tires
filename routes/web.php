<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceAreaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{page:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/service-area/{page:slug}', [ServiceAreaController::class, 'show'])->name('service-areas.show');

// Kept last: catches every remaining flat URL (standard pages + services), e.g. /about-us, /tire-sales.
Route::get('/{page:slug}', [PageController::class, 'show'])->name('pages.show');
