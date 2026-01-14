<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Filters configuration
 *
 * Defines filter aliases and filter application rules.
 * Registers the custom AuthFilter used to protect admin routes.
 */
class Filters extends BaseConfig
{
    /**
     * List of filter aliases for easier reference throughout the app.
     *
     * @var array<string, string>
     */
    public $aliases = [
        'csrf'    => \CodeIgniter\Filters\CSRF::class,
        'toolbar' => \CodeIgniter\Filters\DebugToolbar::class,
        'auth'    => \App\Filters\AuthFilter::class,
    ];

    /**
     * Filters that are applied to every request.
     *
     * @var array<string, array>
     */
    public $globals = [
        'before' => [
            'csrf',
        ],
        'after'  => [
            'toolbar',
        ],
    ];

    /**
     * Filters that are applied before or after certain HTTP methods.
     *
     * @var array<string, array>
     */
    public $methods = [];

    /**
     * Filters that are applied to specific URI patterns.
     *
     * The 'auth' filter is applied before any route that begins with 'admin'.
     *
     * @var array<string, array>
     */
    public $filters = [
        'auth' => [
            'before' => [
                'admin',
                'admin/*',
            ],
        ],
    ];
}
