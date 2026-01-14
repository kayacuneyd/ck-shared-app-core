<?php

$name = $name ?? '';
$type = $type ?? 'text';
$label = $label ?? ucwords(str_replace('_', ' ', $name));
$id = $id ?? $name;
$value = $value ?? old($name);
$required = (bool) ($required ?? false);
$help = $help ?? '';
$options = $options ?? [];
$attributes = $attributes ?? [];
$wrapperClass = $wrapperClass ?? 'mb-3';
$inputClass = $inputClass ?? 'form-control';

$error = null;
if (function_exists('form_field_error')) {
    $error = form_field_error($name);
} else {
    $errors = session('errors') ?? [];
    $error = $errors[$name] ?? null;
}

$attrStr = '';
foreach ($attributes as $key => $val) {
    $attrStr .= ' ' . esc($key) . '="' . esc($val) . '"';
}
?>

<?php if ($type === 'checkbox'): ?>
    <div class="form-check <?= esc($wrapperClass) ?>">
        <input type="checkbox" class="form-check-input<?= $error ? ' is-invalid' : '' ?>"
            id="<?= esc($id) ?>" name="<?= esc($name) ?>" value="<?= esc($value) ?>"
            <?= $required ? 'required' : '' ?><?= $attrStr ?>>
        <label class="form-check-label" for="<?= esc($id) ?>">
            <?= esc($label) ?><?= $required ? ' *' : '' ?>
        </label>
        <?php if ($error): ?>
            <div class="invalid-feedback"><?= esc($error) ?></div>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="<?= esc($wrapperClass) ?>">
        <label for="<?= esc($id) ?>" class="form-label">
            <?= esc($label) ?><?= $required ? ' *' : '' ?>
        </label>

        <?php if ($type === 'textarea'): ?>
            <textarea class="<?= esc($inputClass) ?><?= $error ? ' is-invalid' : '' ?>"
                id="<?= esc($id) ?>" name="<?= esc($name) ?>" <?= $required ? 'required' : '' ?><?= $attrStr ?>><?= esc($value) ?></textarea>
        <?php elseif ($type === 'select'): ?>
            <select class="form-select<?= $error ? ' is-invalid' : '' ?>"
                id="<?= esc($id) ?>" name="<?= esc($name) ?>" <?= $required ? 'required' : '' ?><?= $attrStr ?>>
                <?php foreach ($options as $optValue => $optLabel): ?>
                    <option value="<?= esc($optValue) ?>" <?= (string) $value === (string) $optValue ? 'selected' : '' ?>>
                        <?= esc($optLabel) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <input type="<?= esc($type) ?>" class="<?= esc($inputClass) ?><?= $error ? ' is-invalid' : '' ?>"
                id="<?= esc($id) ?>" name="<?= esc($name) ?>" value="<?= esc($value) ?>"
                <?= $required ? 'required' : '' ?><?= $attrStr ?>>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="invalid-feedback"><?= esc($error) ?></div>
        <?php endif; ?>

        <?php if ($help): ?>
            <small class="form-text text-muted"><?= esc($help) ?></small>
        <?php endif; ?>
    </div>
<?php endif; ?>
