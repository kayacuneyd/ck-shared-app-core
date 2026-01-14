<?php

/**
 * Form Helper
 *
 * Helper functions for form handling, error display, and form field generation.
 * Works with Bootstrap 5 styling.
 *
 * @package App\Helpers
 */

if (!function_exists('form_errors_display')) {
    /**
     * Display all validation errors as a Bootstrap alert.
     *
     * @param array|null $errors Errors array (uses session if null)
     * @return string HTML alert or empty string
     */
    function form_errors_display(?array $errors = null): string
    {
        $errors ??= session('errors') ?? [];

        if (empty($errors)) {
            return '';
        }

        $html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        $html .= '<h6 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> ' . lang('Common.validation_errors') . '</h6>';
        $html .= '<ul class="mb-0 mt-2">';

        foreach ($errors as $field => $message) {
            $html .= '<li>' . esc($message) . '</li>';
        }

        $html .= '</ul></div>';

        return $html;
    }
}

if (!function_exists('form_success_message')) {
    /**
     * Display success message from session.
     *
     * @return string HTML alert or empty string
     */
    function form_success_message(): string
    {
        if (!session()->has('message')) {
            return '';
        }

        $message = session('message');

        return '<div class="alert alert-success alert-dismissible fade show" role="alert">'
            . '<i class="bi bi-check-circle"></i> '
            . esc($message)
            . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            . '</div>';
    }
}

if (!function_exists('form_error_message')) {
    /**
     * Display error message from session.
     *
     * @return string HTML alert or empty string
     */
    function form_error_message(): string
    {
        if (!session()->has('error')) {
            return '';
        }

        $message = session('error');

        return '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
            . '<i class="bi bi-exclamation-circle"></i> '
            . esc($message)
            . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            . '</div>';
    }
}

if (!function_exists('form_all_messages')) {
    /**
     * Display all flash messages (success, error, validation errors).
     *
     * @return string Combined HTML alerts
     */
    function form_all_messages(): string
    {
        return form_success_message() . form_error_message() . form_errors_display();
    }
}

if (!function_exists('form_field_error')) {
    /**
     * Get error message for a specific field.
     *
     * @param string $field Field name
     * @return string|null Error message or null
     */
    function form_field_error(string $field): ?string
    {
        $errors = session('errors') ?? [];
        return $errors[$field] ?? null;
    }
}

if (!function_exists('form_field_class')) {
    /**
     * Get Bootstrap validation class for field.
     *
     * @param string $field Field name
     * @param string $baseClass Base CSS class
     * @return string CSS classes
     */
    function form_field_class(string $field, string $baseClass = 'form-control'): string
    {
        $errors = session('errors') ?? [];

        if (isset($errors[$field])) {
            return $baseClass . ' is-invalid';
        }

        // If form was submitted and no error, mark as valid
        if (!empty(old($field))) {
            return $baseClass . ' is-valid';
        }

        return $baseClass;
    }
}

if (!function_exists('form_input_text')) {
    /**
     * Generate a text input field with Bootstrap styling.
     *
     * @param string $name Field name
     * @param string $label Field label
     * @param array $options Additional options (value, required, placeholder, help, attributes)
     * @return string HTML form field
     */
    function form_input_text(string $name, string $label, array $options = []): string
    {
        $value = $options['value'] ?? old($name) ?? '';
        $required = $options['required'] ?? false;
        $placeholder = $options['placeholder'] ?? '';
        $help = $options['help'] ?? '';
        $type = $options['type'] ?? 'text';
        $attributes = $options['attributes'] ?? [];

        $error = form_field_error($name);
        $class = form_field_class($name);

        $attrStr = '';
        foreach ($attributes as $key => $val) {
            $attrStr .= ' ' . esc($key) . '="' . esc($val) . '"';
        }

        $html = '<div class="mb-3">';
        $html .= '<label for="' . esc($name) . '" class="form-label">';
        $html .= esc($label);
        if ($required) {
            $html .= ' <span class="text-danger">*</span>';
        }
        $html .= '</label>';

        $html .= '<input type="' . esc($type) . '" ';
        $html .= 'class="' . esc($class) . '" ';
        $html .= 'id="' . esc($name) . '" ';
        $html .= 'name="' . esc($name) . '" ';
        $html .= 'value="' . esc($value) . '"';

        if ($placeholder) {
            $html .= ' placeholder="' . esc($placeholder) . '"';
        }
        if ($required) {
            $html .= ' required';
        }

        $html .= $attrStr . '>';

        if ($error) {
            $html .= '<div class="invalid-feedback">' . esc($error) . '</div>';
        }

        if ($help) {
            $html .= '<small class="form-text text-muted">' . esc($help) . '</small>';
        }

        $html .= '</div>';

        return $html;
    }
}

if (!function_exists('form_textarea')) {
    /**
     * Generate a textarea field with Bootstrap styling.
     *
     * @param string $name Field name
     * @param string $label Field label
     * @param array $options Additional options
     * @return string HTML textarea field
     */
    function form_textarea(string $name, string $label, array $options = []): string
    {
        $value = $options['value'] ?? old($name) ?? '';
        $required = $options['required'] ?? false;
        $rows = $options['rows'] ?? 5;
        $help = $options['help'] ?? '';

        $error = form_field_error($name);
        $class = form_field_class($name);

        $html = '<div class="mb-3">';
        $html .= '<label for="' . esc($name) . '" class="form-label">';
        $html .= esc($label);
        if ($required) {
            $html .= ' <span class="text-danger">*</span>';
        }
        $html .= '</label>';

        $html .= '<textarea ';
        $html .= 'class="' . esc($class) . '" ';
        $html .= 'id="' . esc($name) . '" ';
        $html .= 'name="' . esc($name) . '" ';
        $html .= 'rows="' . esc($rows) . '"';

        if ($required) {
            $html .= ' required';
        }

        $html .= '>' . esc($value) . '</textarea>';

        if ($error) {
            $html .= '<div class="invalid-feedback">' . esc($error) . '</div>';
        }

        if ($help) {
            $html .= '<small class="form-text text-muted">' . esc($help) . '</small>';
        }

        $html .= '</div>';

        return $html;
    }
}

if (!function_exists('form_select')) {
    /**
     * Generate a select field with Bootstrap styling.
     *
     * @param string $name Field name
     * @param string $label Field label
     * @param array $options Select options [value => label]
     * @param array $fieldOptions Additional field options
     * @return string HTML select field
     */
    function form_select(string $name, string $label, array $options, array $fieldOptions = []): string
    {
        $value = $fieldOptions['value'] ?? old($name) ?? '';
        $required = $fieldOptions['required'] ?? false;
        $help = $fieldOptions['help'] ?? '';
        $placeholder = $fieldOptions['placeholder'] ?? '-- Select --';

        $error = form_field_error($name);
        $class = form_field_class($name, 'form-select');

        $html = '<div class="mb-3">';
        $html .= '<label for="' . esc($name) . '" class="form-label">';
        $html .= esc($label);
        if ($required) {
            $html .= ' <span class="text-danger">*</span>';
        }
        $html .= '</label>';

        $html .= '<select class="' . esc($class) . '" id="' . esc($name) . '" name="' . esc($name) . '"';
        if ($required) {
            $html .= ' required';
        }
        $html .= '>';

        if ($placeholder) {
            $html .= '<option value="">' . esc($placeholder) . '</option>';
        }

        foreach ($options as $optValue => $optLabel) {
            $selected = $value == $optValue ? ' selected' : '';
            $html .= '<option value="' . esc($optValue) . '"' . $selected . '>' . esc($optLabel) . '</option>';
        }

        $html .= '</select>';

        if ($error) {
            $html .= '<div class="invalid-feedback">' . esc($error) . '</div>';
        }

        if ($help) {
            $html .= '<small class="form-text text-muted">' . esc($help) . '</small>';
        }

        $html .= '</div>';

        return $html;
    }
}

if (!function_exists('form_checkbox')) {
    /**
     * Generate a checkbox field with Bootstrap styling.
     *
     * @param string $name Field name
     * @param string $label Field label
     * @param array $options Additional options
     * @return string HTML checkbox field
     */
    function form_checkbox(string $name, string $label, array $options = []): string
    {
        $checked = $options['checked'] ?? old($name) ?? false;
        $value = $options['value'] ?? '1';

        $html = '<div class="mb-3 form-check">';
        $html .= '<input type="checkbox" class="form-check-input" ';
        $html .= 'id="' . esc($name) . '" ';
        $html .= 'name="' . esc($name) . '" ';
        $html .= 'value="' . esc($value) . '"';

        if ($checked) {
            $html .= ' checked';
        }

        $html .= '>';
        $html .= '<label class="form-check-label" for="' . esc($name) . '">';
        $html .= esc($label);
        $html .= '</label>';
        $html .= '</div>';

        return $html;
    }
}
