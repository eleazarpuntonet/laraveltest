<?php

/**
 * Configuration for FmTod/Quotes package.
 * 
 * These configurations allow customization of API and web routes middleware.
 */

return [
    'api_prefix' => 'api',
    'api_middleware' => ['api', 'auth:sanctum'],
    'web_middleware' => ['web','auth']
];