<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * Autoload Configuration
 *
 * Registers namespace and helper autoloading rules.
 */
class Autoload extends AutoloadConfig
{
    /**
     * PSR-4 Namespaces
     *
     * @var array<string, list<string>|string>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH,
        'App\\Modules' => APPPATH . 'Modules',
    ];

    /**
     * Class Map
     *
     * @var array<string, string>
     */
    public $classmap = [];

    /**
     * Files to include on every request.
     *
     * @var list<string>
     */
    public $files = [
        APPPATH . 'Modules/Property/Helpers/property_helper.php',
    ];

    /**
     * Helpers to load on every request.
     *
     * @var list<string>
     */
    public $helpers = ['url', 'form', 'html', 'text'];
}
