<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Autoload Composer dependencies
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap the application
$app = require_once __DIR__ . '/../bootstrap/app.php';

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

// Capture the incoming request
$request = Request::capture();

// Handle the request through the kernel
$response = $kernel->handle($request);

// Send the response back to the browser
$response->send();

// Terminate the kernel (run any termination middleware)
$kernel->terminate($request, $response);
