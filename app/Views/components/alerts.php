<?php

$session = session();
$alerts = $alerts ?? [];
$errors = $errors ?? $session->getFlashdata('errors');

if ($errors === null) {
    $errors = $session->get('errors') ?? [];
}

$alertMap = [
    'success' => $alerts['success'] ?? $session->getFlashdata('message') ?? $session->getFlashdata('success'),
    'error' => $alerts['error'] ?? $session->getFlashdata('error'),
    'warning' => $alerts['warning'] ?? $session->getFlashdata('warning'),
    'info' => $alerts['info'] ?? $session->getFlashdata('info'),
];

$alertClasses = [
    'success' => 'success',
    'error' => 'danger',
    'warning' => 'warning',
    'info' => 'info',
];
?>

<?php foreach ($alertMap as $type => $message): ?>
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= esc($alertClasses[$type] ?? 'info') ?> alert-dismissible fade show" role="alert">
            <?= esc($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
