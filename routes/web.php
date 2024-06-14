<?php

use Illuminate\Support\Facades\Route;

include base_path('routes/auth.php');
include base_path('routes/admin.php');
include base_path('routes/website.php');
include base_path('routes/payment.php');
include base_path('routes/command.php');

Route::fallback(function () {
    abort(404);
});
