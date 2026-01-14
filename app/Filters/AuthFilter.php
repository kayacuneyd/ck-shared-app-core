<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * AuthFilter
 *
 * This filter checks whether a user is logged in before allowing
 * access to protected routes. If the user is not authenticated
 * they are redirected to the login page.  The filter uses the
 * session service to determine login state.
 */
class AuthFilter implements FilterInterface
{
    /**
     * Before filter.
     *
     * If the user is not logged in, redirect them to the login page.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return ResponseInterface|null
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
    }

    /**
     * After filter (no-op).
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do here
    }
}