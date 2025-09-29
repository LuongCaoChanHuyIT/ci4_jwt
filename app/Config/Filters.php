<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'cors'          => Cors::class,
        'auth'          => \App\Filters\AuthFilter::class,

    ];

    public array $required = [
        'before' => [],
        'after'  => [
            'toolbar',
        ],
    ];

    public array $globals = [
        'before' => [],
        'after'  => [],
    ];

    public array $methods = [
        // Bắt OPTIONS request (preflight) để tránh lỗi CORS
        'options' => ['cors'],
    ];

    public array $filters = [
        // Áp dụng filter cors cho toàn bộ route API
        'cors' => [
            'before' => ['api/*'],
            'after'  => ['api/*'],
        ],
    ];
}
