<?php

/**
 * Date Helper
 *
 * Helper functions for date and time formatting with locale support.
 *
 * @package App\Helpers
 */

if (!function_exists('format_datetime')) {
    /**
     * Format datetime with locale support.
     *
     * @param mixed $datetime DateTime string, object, or timestamp
     * @param string|null $locale Locale code (de, en, tr)
     * @return string Formatted datetime
     *
     * @example format_datetime('2026-01-14 15:30:00', 'tr') => "14.01.2026 15:30"
     */
    function format_datetime(mixed $datetime, ?string $locale = null): string
    {
        if (empty($datetime)) {
            return '-';
        }

        $locale ??= config('App')->defaultLocale ?? 'en';

        if (is_string($datetime)) {
            $datetime = new DateTime($datetime);
        } elseif (is_numeric($datetime)) {
            $datetime = (new DateTime())->setTimestamp($datetime);
        }

        if (!$datetime instanceof DateTimeInterface) {
            return '-';
        }

        return match ($locale) {
            'tr' => $datetime->format('d.m.Y H:i'),
            'de' => $datetime->format('d.m.Y H:i'),
            default => $datetime->format('Y-m-d H:i'),
        };
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date only (no time) with locale support.
     *
     * @param mixed $date Date string, object, or timestamp
     * @param string|null $locale Locale code (de, en, tr)
     * @return string Formatted date
     *
     * @example format_date('2026-01-14', 'tr') => "14.01.2026"
     */
    function format_date(mixed $date, ?string $locale = null): string
    {
        if (empty($date)) {
            return '-';
        }

        $locale ??= config('App')->defaultLocale ?? 'en';

        if (is_string($date)) {
            $date = new DateTime($date);
        } elseif (is_numeric($date)) {
            $date = (new DateTime())->setTimestamp($date);
        }

        if (!$date instanceof DateTimeInterface) {
            return '-';
        }

        return match ($locale) {
            'tr' => $date->format('d.m.Y'),
            'de' => $date->format('d.m.Y'),
            default => $date->format('Y-m-d'),
        };
    }
}

if (!function_exists('format_time')) {
    /**
     * Format time only (no date).
     *
     * @param mixed $time Time string or object
     * @param bool $withSeconds Include seconds
     * @return string Formatted time
     */
    function format_time(mixed $time, bool $withSeconds = false): string
    {
        if (empty($time)) {
            return '-';
        }

        if (is_string($time)) {
            $time = new DateTime($time);
        }

        if (!$time instanceof DateTimeInterface) {
            return '-';
        }

        return $withSeconds ? $time->format('H:i:s') : $time->format('H:i');
    }
}

if (!function_exists('time_ago')) {
    /**
     * Get human-readable time difference (e.g., "2 hours ago").
     *
     * @param mixed $datetime DateTime to compare
     * @param string|null $locale Locale for translations
     * @return string Human-readable time difference
     *
     * @example time_ago('2026-01-14 13:00:00') => "2 hours ago"
     */
    function time_ago(mixed $datetime, ?string $locale = null): string
    {
        if (empty($datetime)) {
            return '-';
        }

        $locale ??= config('App')->defaultLocale ?? 'en';

        if (is_string($datetime)) {
            $datetime = new DateTime($datetime);
        }

        if (!$datetime instanceof DateTimeInterface) {
            return '-';
        }

        $now = new DateTime();
        $diff = $now->diff($datetime);

        // Translations
        $translations = [
            'en' => [
                'just_now' => 'just now',
                'seconds' => '%d seconds ago',
                'minute' => '1 minute ago',
                'minutes' => '%d minutes ago',
                'hour' => '1 hour ago',
                'hours' => '%d hours ago',
                'day' => 'yesterday',
                'days' => '%d days ago',
                'week' => '1 week ago',
                'weeks' => '%d weeks ago',
                'month' => '1 month ago',
                'months' => '%d months ago',
                'year' => '1 year ago',
                'years' => '%d years ago',
            ],
            'tr' => [
                'just_now' => 'az once',
                'seconds' => '%d saniye once',
                'minute' => '1 dakika once',
                'minutes' => '%d dakika once',
                'hour' => '1 saat once',
                'hours' => '%d saat once',
                'day' => 'dun',
                'days' => '%d gun once',
                'week' => '1 hafta once',
                'weeks' => '%d hafta once',
                'month' => '1 ay once',
                'months' => '%d ay once',
                'year' => '1 yil once',
                'years' => '%d yil once',
            ],
            'de' => [
                'just_now' => 'gerade eben',
                'seconds' => 'vor %d Sekunden',
                'minute' => 'vor 1 Minute',
                'minutes' => 'vor %d Minuten',
                'hour' => 'vor 1 Stunde',
                'hours' => 'vor %d Stunden',
                'day' => 'gestern',
                'days' => 'vor %d Tagen',
                'week' => 'vor 1 Woche',
                'weeks' => 'vor %d Wochen',
                'month' => 'vor 1 Monat',
                'months' => 'vor %d Monaten',
                'year' => 'vor 1 Jahr',
                'years' => 'vor %d Jahren',
            ],
        ];

        $t = $translations[$locale] ?? $translations['en'];

        if ($diff->y > 0) {
            return $diff->y === 1 ? $t['year'] : sprintf($t['years'], $diff->y);
        }
        if ($diff->m > 0) {
            return $diff->m === 1 ? $t['month'] : sprintf($t['months'], $diff->m);
        }
        if ($diff->d >= 7) {
            $weeks = floor($diff->d / 7);
            return $weeks === 1 ? $t['week'] : sprintf($t['weeks'], $weeks);
        }
        if ($diff->d > 0) {
            return $diff->d === 1 ? $t['day'] : sprintf($t['days'], $diff->d);
        }
        if ($diff->h > 0) {
            return $diff->h === 1 ? $t['hour'] : sprintf($t['hours'], $diff->h);
        }
        if ($diff->i > 0) {
            return $diff->i === 1 ? $t['minute'] : sprintf($t['minutes'], $diff->i);
        }
        if ($diff->s > 10) {
            return sprintf($t['seconds'], $diff->s);
        }

        return $t['just_now'];
    }
}

if (!function_exists('is_past')) {
    /**
     * Check if datetime is in the past.
     *
     * @param mixed $datetime DateTime to check
     * @return bool True if past
     */
    function is_past(mixed $datetime): bool
    {
        if (empty($datetime)) {
            return false;
        }

        if (is_string($datetime)) {
            $datetime = new DateTime($datetime);
        }

        if (!$datetime instanceof DateTimeInterface) {
            return false;
        }

        return $datetime < new DateTime();
    }
}

if (!function_exists('is_future')) {
    /**
     * Check if datetime is in the future.
     *
     * @param mixed $datetime DateTime to check
     * @return bool True if future
     */
    function is_future(mixed $datetime): bool
    {
        if (empty($datetime)) {
            return false;
        }

        if (is_string($datetime)) {
            $datetime = new DateTime($datetime);
        }

        if (!$datetime instanceof DateTimeInterface) {
            return false;
        }

        return $datetime > new DateTime();
    }
}

if (!function_exists('is_today')) {
    /**
     * Check if date is today.
     *
     * @param mixed $date Date to check
     * @return bool True if today
     */
    function is_today(mixed $date): bool
    {
        if (empty($date)) {
            return false;
        }

        if (is_string($date)) {
            $date = new DateTime($date);
        }

        if (!$date instanceof DateTimeInterface) {
            return false;
        }

        return $date->format('Y-m-d') === (new DateTime())->format('Y-m-d');
    }
}

if (!function_exists('days_between')) {
    /**
     * Calculate days between two dates.
     *
     * @param mixed $date1 First date
     * @param mixed $date2 Second date (defaults to now)
     * @return int Number of days
     */
    function days_between(mixed $date1, mixed $date2 = null): int
    {
        if (is_string($date1)) {
            $date1 = new DateTime($date1);
        }

        if ($date2 === null) {
            $date2 = new DateTime();
        } elseif (is_string($date2)) {
            $date2 = new DateTime($date2);
        }

        if (!$date1 instanceof DateTimeInterface || !$date2 instanceof DateTimeInterface) {
            return 0;
        }

        return (int) $date1->diff($date2)->days;
    }
}
