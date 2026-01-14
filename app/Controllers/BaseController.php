<?php

namespace App\Controllers;

use App\Libraries\AuditLog;
use CodeIgniter\Controller;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * The base controller from which all other controllers extend.
 * Provides a common place to load helper functions and initialise
 * the session service.  Also sets up logging.
 */
class BaseController extends Controller
{
    /**
     * Helper libraries to be loaded automatically upon instantiation.
     *
     * @var array<string>
     */
    protected $helpers = ['url', 'html', 'form', 'ck', 'date', 'security'];

    /**
     * Instance of the main Request object.
     *
     * @var \CodeIgniter\HTTP\RequestInterface
     */
    protected $request;

    /**
     * Session instance for convenience.
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    /**
     * Audit logger instance.
     *
     * @var AuditLog
     */
    protected AuditLog $auditLog;

    /**
     * Initialization code shared by all controllers.
     *
     * @param \CodeIgniter\HTTP\RequestInterface  $request
     * @param \CodeIgniter\HTTP\ResponseInterface $response
     * @param LoggerInterface                        $logger
     */
    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        LoggerInterface $logger
    ) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->session = session();
        $this->auditLog = new AuditLog();
    }

    /**
     * Convenience wrapper for audit logging.
     *
     * @param string $action Audit action name
     * @param array $context Extra context data
     */
    protected function audit(string $action, array $context = []): void
    {
        $this->auditLog->log($action, $context);
    }
}
