<?php

/**
 * Property Helper Functions
 *
 * Utility functions for formatting and displaying property data.
 */

if (!function_exists('format_price')) {
    /**
     * Format a price as currency.
     *
     * @param float|int $price The price to format
     * @param string $currency The currency symbol (default: €)
     * @return string Formatted price
     */
    function format_price($price, string $currency = '€'): string
    {
        return $currency . ' ' . number_format((float) $price, 2, ',', '.');
    }
}

if (!function_exists('property_status_badge')) {
    /**
     * Generate a Bootstrap badge for property status.
     *
     * @param string $status The property status (available, reserved, sold)
     * @return string HTML badge element
     */
    function property_status_badge(string $status): string
    {
        $badges = [
            'available' => '<span class="badge bg-success">' . lang('Property.status.available') . '</span>',
            'reserved' => '<span class="badge bg-warning text-dark">' . lang('Property.status.reserved') . '</span>',
            'sold' => '<span class="badge bg-secondary">' . lang('Property.status.sold') . '</span>',
        ];

        return $badges[$status] ?? '<span class="badge bg-light text-dark">' . esc($status) . '</span>';
    }
}

if (!function_exists('property_url')) {
    /**
     * Generate the URL for a property detail page.
     *
     * @param string $slug The property slug
     * @return string The full URL
     */
    function property_url(string $slug): string
    {
        return base_url('properties/' . $slug);
    }
}

if (!function_exists('property_admin_url')) {
    /**
     * Generate the admin URL for a property.
     *
     * @param int $id The property ID
     * @param string $action The action (edit, delete, etc.)
     * @return string The full admin URL
     */
    function property_admin_url(int $id, string $action = ''): string
    {
        $url = 'admin/properties/' . $id;
        if (!empty($action)) {
            $url .= '/' . $action;
        }
        return base_url($url);
    }
}

if (!function_exists('format_area')) {
    /**
     * Format area in square meters.
     *
     * @param float|int $area The area in square meters
     * @return string Formatted area with unit
     */
    function format_area($area): string
    {
        if (empty($area)) {
            return '-';
        }
        return number_format((float) $area, 2, ',', '.') . ' m²';
    }
}
