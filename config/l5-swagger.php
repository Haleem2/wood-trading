<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Wood Trading API Documentation',
            ],
            'routes' => [
                'docs' => 'api/documentation',
                'oauth2_callback' => 'api/oauth2-callback',
                'middleware' => [
                    'api' => [],
                    'asset' => [],
                    'docs' => [],
                    'oauth2_callback' => [],
                ],
                'group_options' => [],
            ],
            'paths' => [
                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
                'docs' => storage_path('api-docs'),
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),
                'annotations' => [
                    base_path('app'),
                ],
                'excludes' => [],
                'base' => base_path(),
            ],
        ],
    ],
    'defaults' => [
        'routes' => [
            'docs' => 'api/documentation',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
            'group_options' => [],
        ],
        'paths' => [
            'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
            'docs' => storage_path('api-docs'),
            'docs_json' => 'api-docs.json',
            'docs_yaml' => 'api-docs.yaml',
            'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),
            'annotations' => [
                base_path('app'),
            ],
            'excludes' => [],
            'base' => base_path(),
        ],
        'scanOptions' => [
            'exclude' => [],
            'pattern' => '*.php',
            'open_api_spec' => '3.0.0',
        ],
        'securityDefinitions' => [
            'securitySchemes' => [
                'sanctum' => [
                    'type' => 'http',
                    'description' => 'Enter token in the format: Bearer {token}',
                    'name' => 'Authorization',
                    'in' => 'header',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'JWT',
                ],
            ],
            'security' => [
                [
                    'sanctum' => [],
                ],
            ],
        ],
        'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
        'generate_yml_files' => env('L5_SWAGGER_GENERATE_YAML_FILES', false),
        'proxy' => false,
        'additional_config_url' => null,
        'operations' => [],
        'validator' => [
            'validate' => env('L5_SWAGGER_VALIDATE', true),
        ],
        'ui' => [
            'title' => 'Wood Trading API Documentation',
            'theme' => 'default',
            'display_operation_id' => false,
            'display_request_duration' => true,
            'doc_expansion' => 'none',
            'filter' => false,
            'show_extensions' => false,
            'show_common_extensions' => false,
            'try_it_out_enabled' => true,
        ],
        'constants' => [
            'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost'),
        ],
    ],
];