<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Application Configuration
 *
 * Core configuration for the CodeIgniter application.
 */
class App extends BaseConfig
{
    /**
     * Base site URL.
     *
     * @var string
     */
    public string $baseURL = 'http://localhost:8080/';

    /**
     * Valid hostnames.
     *
     * @var list<string>
     */
    public array $allowedHostnames = [];

    /**
     * Index file.
     *
     * @var string
     */
    public string $indexPage = '';

    /**
     * URI protocol.
     *
     * @var string
     */
    public string $uriProtocol = 'REQUEST_URI';

    /**
     * Default locale.
     *
     * @var string
     */
    public string $defaultLocale = 'de';

    /**
     * Negotiate locale.
     *
     * @var bool
     */
    public bool $negotiateLocale = true;

    /**
     * Supported locales.
     *
     * @var list<string>
     */
    public array $supportedLocales = ['de', 'en', 'tr'];

    /**
     * Application timezone.
     *
     * @var string
     */
    public string $appTimezone = 'Europe/Berlin';

    /**
     * Default charset.
     *
     * @var string
     */
    public string $charset = 'UTF-8';

    /**
     * Force global secure requests.
     *
     * @var bool
     */
    public bool $forceGlobalSecureRequests = false;

    /**
     * Reverse proxy IPs.
     *
     * @var list<string>
     */
    public array $proxyIPs = [];

    /**
     * CSRF protection method.
     *
     * @var string
     */
    public string $CSRFTokenName = 'csrf_token';

    /**
     * CSRF header name.
     *
     * @var string
     */
    public string $CSRFHeaderName = 'X-CSRF-TOKEN';

    /**
     * CSRF cookie name.
     *
     * @var string
     */
    public string $CSRFCookieName = 'csrf_cookie';

    /**
     * CSRF expiration time.
     *
     * @var int
     */
    public int $CSRFExpire = 7200;

    /**
     * CSRF regeneration.
     *
     * @var bool
     */
    public bool $CSRFRegenerate = true;

    /**
     * CSRF redirect.
     *
     * @var bool
     */
    public bool $CSRFRedirect = true;

    /**
     * Content Security Policy.
     *
     * @var bool
     */
    public bool $CSPEnabled = false;
}
