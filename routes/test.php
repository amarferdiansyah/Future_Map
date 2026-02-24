<?php
// routes/test.php
use App\Http\Controllers\CareerPathController;

Route::get('/test-controller', function() {
    $controller = new CareerPathController();
    return "Controller loaded successfully!";
});