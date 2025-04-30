<?php

use App\Events\TestEvent;
use App\Http\Controllers\Chat\SentMessage;
use App\Http\Controllers\Customer\CustomerChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportStaff\Auth\SupportAuthController;
use App\Http\Controllers\SupportStaff\chat\SupportChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/customer/chat/view', [CustomerChatController::class, 'view'])->name('customer.chat.view');
    Route::get('/customer/chat/show/{conversation}', [CustomerChatController::class, 'show'])->name('customer.chat.show');
    Route::post('/customer/chat/send/{conversation}', [SentMessage::class, '__invoke'])->name('customer.chat.send');

});

Route::prefix('support')->group(function () {
    Route::get('/login', [SupportAuthController::class, 'show'])->name('support.login');
    Route::post('/login', [SupportAuthController::class, 'login'])->name('support.login.submit');
    Route::post('/logout', [SupportAuthController::class, 'logout'])->name('support.logout');

    Route::middleware('support')->group(function () {
        Route::get('/dashboard', function () {
            return view('support.dashboard');
        })->name('support.dashboard');
        Route::get('/chat/requests', [SupportChatController::class, 'request'])->name('support.chat.requests');
        Route::get('/chat/view/{conversation}', [SupportChatController::class, 'view'])->name('support.chat.view');
        Route::post('/support/chat/send/{conversation}', [SentMessage::class, '__invoke'])->name('support.chat.send');
    });
});

require __DIR__.'/auth.php';
