<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

if (! is_writable($app->bootstrapPath('cache'))) {
    $cacheDirectory = sys_get_temp_dir().DIRECTORY_SEPARATOR.'laravel-bootstrap-'.substr(hash('sha256', $app->basePath()), 0, 16);

    if (! is_dir($cacheDirectory) && ! mkdir($cacheDirectory, 0755, true) && ! is_dir($cacheDirectory)) {
        throw new RuntimeException("Unable to create Laravel's temporary bootstrap cache directory: {$cacheDirectory}");
    }

    if (! is_writable($cacheDirectory)) {
        throw new RuntimeException("Laravel's temporary bootstrap cache directory is not writable: {$cacheDirectory}");
    }

    $app->addAbsoluteCachePathPrefix(substr($cacheDirectory, 0, 3));

    foreach (['APP_PACKAGES_CACHE' => 'packages.php', 'APP_SERVICES_CACHE' => 'services.php'] as $key => $file) {
        if (getenv($key) === false) {
            putenv($key.'='.$cacheDirectory.DIRECTORY_SEPARATOR.$file);
        }
    }
}

return $app;
