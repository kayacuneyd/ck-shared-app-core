<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

/**
 * LoginController
 *
 * Handles showing the login form, processing login attempts,
 * and logging the user out.  Uses the UserModel to fetch
 * user records and verifies passwords using PHP's
 * password_hash/password_verify functions.
 */
class LoginController extends BaseController
{
    /**
     * Display the login form.
     *
     * @return string
     */
    public function index(): string
    {
        helper(['form']);
        return view('auth/login');
    }

    /**
     * Attempt to log the user in.
     *
     * Validates the incoming form input and then checks the
     * provided credentials against the database. If successful
     * the user is stored in the session and redirected to the
     * admin dashboard. On failure, the user is sent back to
     * the login form with an error message.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function attempt()
    {
        helper(['form']);
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = (string) $this->request->getPost('email');
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();
        $user      = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session = session();
            $session->set([
                'user_id'    => $user['id'],
                'user_email' => $user['email'],
                'user_name'  => $user['name'],
                'role'       => $user['role'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/admin');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    /**
     * Log the user out.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}