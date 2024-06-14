<?php

use Illuminate\Support\Facades\Route;
use Modules\Newsletter\Http\Controllers\NewsletterController;

Route::middleware(['auth:admin', 'set_lang'])->prefix('admin/newsletter')->group(function () {

    Route::get('/', [NewsletterController::class, 'index'])->name('module.newsletter.index');
    Route::delete('/delete/{email}', [NewsletterController::class, 'destroy'])->name('module.newsletter.delete');
    Route::post('/email/export', [NewsletterController::class, 'download'])->name('module.newsletter.export');
});
// store email from frontend user
Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
