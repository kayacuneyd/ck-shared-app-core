<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Session\Handlers\FileHandler;

/**
 * Session Configuration
 */
class Session extends BaseConfig
{
    /**
     * Session driver.
     *
     * @var class-string
     */
    public string $driver = FileHandler::class;

    /**
     * Session cookie name.
     *
     * @var string
     */
    public string $cookieName = 'ci_session';

    /**
     * Session expiration.
     *
     * @var int
     */
    public int $expiration = 7200;

    /**
     * Session save path.
     *
     * @var string
     */
    public string $savePath = WRITEPATH . 'session';

    /**
     * Match IP address.
     *
     * @var bool
     */
    public bool $matchIP = false;

    /**
     * Time to update.
     *
     * @var int
     */
    public int $timeToUpdate = 300;

    /**
     * Regenerate destroy.
     *
     * @var bool
     */
    public bool $regenerateDestroy = false;

    /**
     * Cookie domain.
     *
     * @var string
     */
    public string $cookieDomain = '';

    /**
     * Cookie path.
     *
     * @var string
     */
    public string $cookiePath = '/';

    /**
     * Cookie secure.
     *
     * @var bool
     */
    public bool $cookieSecure = false;

    /**
     * Cookie SameSite.
     *
     * @var string
     */
    public string $cookieSameSite = 'Lax';
}
