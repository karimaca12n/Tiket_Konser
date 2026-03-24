<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Cross-Origin Resource Sharing (CORS) Configuration for Tiket Konser API
 * Development: Allows localhost:* for Flutter Web (random ports)
 * Production: Restrict to your frontend domain
 */
class Cors extends BaseConfig
{
    public array $default = [
        // Development: Allow all localhost ports for Flutter Web
        'allowedOrigins' => ['http://localhost:8081'], // Backend itself + specific
        
        // Regex pattern for random Flutter ports: http://localhost:XXXXX
        'allowedOriginsPatterns' => ['^http://localhost:\\d+$'], 
        
        'supportsCredentials' => false,
        
        // Flutter common headers
        'allowedHeaders' => [
            'Origin',
            'X-Requested-With', 
            'Content-Type',
            'Accept',
            'Authorization',
            'X-API-KEY'
        ],
        
        'exposedHeaders' => ['Content-Length', 'X-API-KEY'],
        
        // REST methods
        'allowedMethods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH'],
        
        'maxAge' => 7200, // 2 hours preflight cache
    ];
}
