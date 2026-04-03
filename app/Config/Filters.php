<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\Cors; // Pastikan mengarah ke App\Filters\Cors

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class, // Register alias cors
    ];

    public array $required = [
        'before' => [
            // 'forcehttps', <--- WAJIB DIMATIKAN (Diberi komentar)
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public array $globals = [
        'before' => [
            'cors', // Aktifkan CORS secara global
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public array $methods = [];
    public array $filters = [];
}