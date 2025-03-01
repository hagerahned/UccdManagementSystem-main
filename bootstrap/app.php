<?php

use App\Http\Middleware\IsInstructor;
use App\Http\Middleware\IsManager;
use App\Http\Middleware\IsStudent;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix:'api/v1',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_manager' => IsManager::class,
            'is_instructor' => IsInstructor::class,
            'is_student' => IsStudent::class,
            
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
