<?php

// config for FmTod/Quotes
return [
    'api_prefix' => 'api',
    'api_middleware' => ['api', 'auth:sanctum'],
    'web_middleware' => ['web','auth']
];