<?php

/**
 * Security Helper
 *
 * Helper functions for input sanitization, validation, and security checks.
 *
 * @package App\Helpers
 */

if (!function_exists('sanitize_input')) {
    /**
     * Sanitize user input based on type.
     *
     * @param string|null $data Data to sanitize
     * @param string $type Type of sanitization (string, email, url, number, html)
     * @return string Sanitized data
     *
     * @example sanitize_input('<script>alert(1)</script>', 'string') => "alert(1)"
     * @example sanitize_input('test@example.com', 'email') => "test@example.com"
     */
    function sanitize_input(?string $data, string $type = 'string'): string
    {
        if ($data === null) {
            return '';
        }

        return match ($type) {
            'email' => filter_var(trim($data), FILTER_SANITIZE_EMAIL),
            'url' => filter_var(trim($data), FILTER_SANITIZE_URL),
            'number' => preg_replace('/[^0-9.-]/', '', $data),
            'int' => (string) filter_var($data, FILTER_SANITIZE_NUMBER_INT),
            'float' => (string) filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            'alpha' => preg_replace('/[^a-zA-Z]/', '', $data),
            'alphanumeric' => preg_replace('/[^a-zA-Z0-9]/', '', $data),
            'html' => strip_tags($data),
            default => htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8'),
        };
    }
}

if (!function_exists('sanitize_filename')) {
    /**
     * Sanitize filename for safe file operations.
     *
     * @param string $filename Filename to sanitize
     * @return string Safe filename
     */
    function sanitize_filename(string $filename): string
    {
        // Remove path traversal attempts
        $filename = basename($filename);

        // Replace dangerous characters
        $filename = preg_replace('/[^\w\s\-\.]/', '', $filename);

        // Remove multiple spaces/dots
        $filename = preg_replace('/[\s]+/', '_', $filename);
        $filename = preg_replace('/[\.]+/', '.', $filename);

        // Trim dots and spaces from ends
        $filename = trim($filename, '. ');

        // Ensure not empty
        if (empty($filename)) {
            $filename = 'file_' . time();
        }

        return $filename;
    }
}

if (!function_exists('validate_honeypot')) {
    /**
     * Check honeypot field for bot protection.
     *
     * Honeypot is a hidden field that should remain empty.
     * Bots typically fill all fields, so if it's filled, it's likely a bot.
     *
     * @param string $fieldName Name of honeypot field
     * @return bool True if honeypot is clean (not a bot)
     */
    function validate_honeypot(string $fieldName = 'website'): bool
    {
        $request = service('request');
        $honeypotValue = $request->getPost($fieldName);

        return empty($honeypotValue);
    }
}

if (!function_exists('generate_token')) {
    /**
     * Generate a secure random token.
     *
     * @param int $length Token length in bytes (result will be 2x in hex)
     * @return string Random token
     */
    function generate_token(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }
}

if (!function_exists('generate_password')) {
    /**
     * Generate a secure random password.
     *
     * @param int $length Password length
     * @param bool $includeSymbols Include special characters
     * @return string Random password
     */
    function generate_password(int $length = 16, bool $includeSymbols = true): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        if ($includeSymbols) {
            $chars .= '!@#$%^&*()_+-=[]{}|';
        }

        $password = '';
        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $max)];
        }

        return $password;
    }
}

if (!function_exists('hash_password')) {
    /**
     * Hash password using bcrypt.
     *
     * @param string $password Plain text password
     * @return string Hashed password
     */
    function hash_password(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}

if (!function_exists('verify_password')) {
    /**
     * Verify password against hash.
     *
     * @param string $password Plain text password
     * @param string $hash Password hash
     * @return bool True if password matches
     */
    function verify_password(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}

if (!function_exists('mask_email')) {
    /**
     * Mask email address for privacy.
     *
     * @param string $email Email address
     * @return string Masked email
     *
     * @example mask_email('test@example.com') => "t***@e***.com"
     */
    function mask_email(string $email): string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }

        [$local, $domain] = explode('@', $email);
        [$domainName, $tld] = explode('.', $domain, 2);

        $maskedLocal = substr($local, 0, 1) . str_repeat('*', max(strlen($local) - 1, 3));
        $maskedDomain = substr($domainName, 0, 1) . str_repeat('*', max(strlen($domainName) - 1, 3));

        return $maskedLocal . '@' . $maskedDomain . '.' . $tld;
    }
}

if (!function_exists('mask_phone')) {
    /**
     * Mask phone number for privacy.
     *
     * @param string $phone Phone number
     * @return string Masked phone
     *
     * @example mask_phone('+491234567890') => "+49****7890"
     */
    function mask_phone(string $phone): string
    {
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        if (strlen($phone) < 6) {
            return $phone;
        }

        $visible = 4;
        $prefix = substr($phone, 0, strlen($phone) - $visible - 4);
        $suffix = substr($phone, -$visible);

        return $prefix . str_repeat('*', 4) . $suffix;
    }
}

if (!function_exists('is_valid_email')) {
    /**
     * Validate email address.
     *
     * @param string $email Email to validate
     * @return bool True if valid
     */
    function is_valid_email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('is_valid_url')) {
    /**
     * Validate URL.
     *
     * @param string $url URL to validate
     * @return bool True if valid
     */
    function is_valid_url(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}

if (!function_exists('is_strong_password')) {
    /**
     * Check if password meets strength requirements.
     *
     * Requirements:
     * - Minimum 8 characters
     * - At least one uppercase letter
     * - At least one lowercase letter
     * - At least one number
     *
     * @param string $password Password to check
     * @param int $minLength Minimum length (default 8)
     * @return bool True if strong
     */
    function is_strong_password(string $password, int $minLength = 8): bool
    {
        if (strlen($password) < $minLength) {
            return false;
        }

        // Must contain uppercase
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        // Must contain lowercase
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        // Must contain number
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        return true;
    }
}

if (!function_exists('rate_limit_check')) {
    /**
     * Simple rate limiting check using session.
     *
     * @param string $action Action identifier
     * @param int $maxAttempts Maximum attempts allowed
     * @param int $decaySeconds Time window in seconds
     * @return bool True if within limit, false if exceeded
     */
    function rate_limit_check(string $action, int $maxAttempts = 5, int $decaySeconds = 60): bool
    {
        $session = session();
        $key = 'rate_limit_' . $action;
        $data = $session->get($key) ?? ['attempts' => 0, 'first_attempt' => time()];

        // Reset if window expired
        if (time() - $data['first_attempt'] > $decaySeconds) {
            $data = ['attempts' => 0, 'first_attempt' => time()];
        }

        // Check limit
        if ($data['attempts'] >= $maxAttempts) {
            return false;
        }

        // Increment
        $data['attempts']++;
        $session->set($key, $data);

        return true;
    }
}
