<?php

$brand = $brand ?? '';
$brandUrl = $brandUrl ?? '/';
$brandIcon = $brandIcon ?? '';
$navItems = $navItems ?? [];
$loginUrl = $loginUrl ?? null;
$loginLabel = $loginLabel ?? '';
$loginIcon = $loginIcon ?? '';
?>

<nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= esc($brandUrl) ?>">
            <?php if ($brandIcon): ?>
                <i class="bi <?= esc($brandIcon) ?> me-2"></i>
            <?php endif; ?>
            <?= esc($brand) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php foreach ($navItems as $item): ?>
                    <?php
                    $href = $item['href'] ?? '#';
                    $label = $item['label'] ?? '';
                    $icon = $item['icon'] ?? '';
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= esc($href) ?>">
                            <?php if ($icon): ?>
                                <i class="bi <?= esc($icon) ?> me-1"></i>
                            <?php endif; ?>
                            <?= esc($label) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if ($loginUrl && $loginLabel): ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="<?= esc($loginUrl) ?>">
                            <?php if ($loginIcon): ?>
                                <i class="bi <?= esc($loginIcon) ?> me-1"></i>
                            <?php endif; ?>
                            <?= esc($loginLabel) ?>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
