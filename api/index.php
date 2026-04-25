<?php
// api/index.php - This is the entry point for Vercel

// Load Laravel's autoloader
require __DIR__ . '/../vendor/autoload.php';

// Create Laravel application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Handle the request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Send response
$response->send();

// Terminate
$kernel->terminate($request, $response);