<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Throwable;

class LoggingService
{
    public function info($controller, string $message, array $context = [])
    {
        Log::info('[' . $controller . ']->' . $message, $this->formatContext($context));
    }

    public function warning($controller, string $message, array $context = [])
    {
        Log::warning('[' . $controller . ']->' . $message, $this->formatContext($context));
    }

    public function error($controller, string $message, ?Throwable $e = null, array $context = [])
    {
        if ($e)
        {
            $context['exception'] = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ];
        }

        Log::error('[' . $controller . ']->' . $message, $this->formatContext($context));
    }

    protected function formatContext(array $context = []): array
    {
        return array_merge([
            'app_env' => config('app.env'),
            'url' => request()->fullUrl() ?? null,
            'ip' => request()->ip() ?? null,
            'user_id' => Auth::id() ?? null,
        ], $context);
    }
}
