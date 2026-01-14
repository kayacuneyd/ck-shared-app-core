<?php

/**
 * CK Helper
 *
 * Common utility functions used across CK Shared App Core.
 * Functions for formatting, text manipulation, and data transformation.
 *
 * @package App\Helpers
 */

if (!function_exists('format_currency')) {
    /**
     * Format value as currency with locale support.
     *
     * @param float|int|null $amount The amount to format
     * @param string $currency Currency code (EUR, USD, TRY)
     * @param string|null $locale Locale code (de, en, tr)
     * @return string Formatted currency string
     *
     * @example format_currency(1234.56, 'EUR', 'de') => "1.234,56 €"
     * @example format_currency(1234.56, 'USD', 'en') => "$1,234.56"
     */
    function format_currency(float|int|null $amount, string $currency = 'EUR', ?string $locale = null): string
    {
        if ($amount === null) {
            return '-';
        }

        $locale ??= config('App')->defaultLocale ?? 'en';

        $symbols = [
            'EUR' => '€',
            'USD' => '$',
            'TRY' => '₺',
            'GBP' => '£',
        ];

        $symbol = $symbols[$currency] ?? $currency;

        // Format based on locale
        return match ($locale) {
            'de', 'tr' => number_format($amount, 2, ',', '.') . ' ' . $symbol,
            default => $symbol . number_format($amount, 2, '.', ','),
        };
    }
}

if (!function_exists('truncate_text')) {
    /**
     * Truncate text to specified length with suffix.
     *
     * @param string|null $text Text to truncate
     * @param int $length Maximum length
     * @param string $suffix Suffix to append
     * @return string Truncated text
     *
     * @example truncate_text("Hello World", 5) => "Hello..."
     */
    function truncate_text(?string $text, int $length = 100, string $suffix = '...'): string
    {
        if ($text === null || $text === '') {
            return '';
        }

        if (mb_strlen($text) <= $length) {
            return $text;
        }

        return mb_substr($text, 0, $length) . $suffix;
    }
}

if (!function_exists('generate_slug')) {
    /**
     * Generate URL-friendly slug from text.
     *
     * @param string $text Text to convert
     * @return string URL-friendly slug
     *
     * @example generate_slug("Hello World!") => "hello-world"
     */
    function generate_slug(string $text): string
    {
        // Convert to lowercase
        $slug = mb_strtolower($text);

        // Replace Turkish characters
        $replacements = [
            'ş' => 's', 'ı' => 'i', 'ğ' => 'g', 'ü' => 'u', 'ö' => 'o', 'ç' => 'c',
            'Ş' => 's', 'İ' => 'i', 'Ğ' => 'g', 'Ü' => 'u', 'Ö' => 'o', 'Ç' => 'c',
            'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss',
        ];
        $slug = strtr($slug, $replacements);

        // Remove non-alphanumeric characters
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

        // Replace spaces and underscores with hyphens
        $slug = preg_replace('/[\s_]+/', '-', $slug);

        // Remove multiple consecutive hyphens
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim hyphens from ends
        return trim($slug, '-');
    }
}

if (!function_exists('format_bytes')) {
    /**
     * Format bytes to human readable size.
     *
     * @param int $bytes Bytes to format
     * @param int $precision Decimal precision
     * @return string Formatted size
     *
     * @example format_bytes(1024) => "1 KB"
     * @example format_bytes(1048576) => "1 MB"
     */
    function format_bytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('is_active_route')) {
    /**
     * Check if current route matches given pattern.
     *
     * @param string $pattern Route pattern to match
     * @return bool True if current route matches
     *
     * @example is_active_route('admin/*') => true on /admin/properties
     */
    function is_active_route(string $pattern): bool
    {
        $currentPath = service('uri')->getPath();

        // Exact match
        if ($pattern === $currentPath) {
            return true;
        }

        // Wildcard match
        if (str_contains($pattern, '*')) {
            $regex = str_replace('*', '.*', $pattern);
            return (bool) preg_match('#^' . $regex . '$#', $currentPath);
        }

        return false;
    }
}

if (!function_exists('active_class')) {
    /**
     * Return CSS class if route is active.
     *
     * @param string $pattern Route pattern to match
     * @param string $activeClass Class to return if active
     * @param string $inactiveClass Class to return if inactive
     * @return string CSS class
     *
     * @example active_class('admin/*', 'active') => "active" on /admin/properties
     */
    function active_class(string $pattern, string $activeClass = 'active', string $inactiveClass = ''): string
    {
        return is_active_route($pattern) ? $activeClass : $inactiveClass;
    }
}

if (!function_exists('pluralize')) {
    /**
     * Simple pluralization for common words.
     *
     * @param int $count Count
     * @param string $singular Singular form
     * @param string $plural Plural form (optional, adds 's' if not provided)
     * @return string Pluralized word with count
     *
     * @example pluralize(1, 'item') => "1 item"
     * @example pluralize(5, 'item') => "5 items"
     */
    function pluralize(int $count, string $singular, ?string $plural = null): string
    {
        $plural ??= $singular . 's';
        $word = $count === 1 ? $singular : $plural;
        return $count . ' ' . $word;
    }
}

if (!function_exists('array_get')) {
    /**
     * Get value from array using dot notation.
     *
     * @param array $array Source array
     * @param string $key Key with dot notation
     * @param mixed $default Default value if not found
     * @return mixed Value or default
     *
     * @example array_get(['user' => ['name' => 'John']], 'user.name') => "John"
     */
    function array_get(array $array, string $key, mixed $default = null): mixed
    {
        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }
            $array = $array[$segment];
        }

        return $array;
    }
}

if (!function_exists('flash_message')) {
    /**
     * Set a flash message to session.
     *
     * @param string $message Message text
     * @param string $type Message type (success, error, warning, info)
     * @return void
     */
    function flash_message(string $message, string $type = 'success'): void
    {
        session()->setFlashdata($type === 'success' ? 'message' : $type, $message);
    }
}

if (!function_exists('get_gravatar')) {
    /**
     * Get Gravatar URL for email.
     *
     * @param string $email Email address
     * @param int $size Image size in pixels
     * @param string $default Default image type (mp, identicon, monsterid, wavatar, retro, robohash)
     * @return string Gravatar URL
     */
    function get_gravatar(string $email, int $size = 80, string $default = 'mp'): string
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d={$default}";
    }
}
