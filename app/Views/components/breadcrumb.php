<?php

$items = $items ?? [];
if (empty($items)) {
    return;
}

$containerClass = $containerClass ?? '';
?>

<nav aria-label="breadcrumb" class="<?= esc($containerClass) ?>">
    <ol class="breadcrumb">
        <?php foreach ($items as $item): ?>
            <?php
            $label = $item['label'] ?? '';
            $url = $item['url'] ?? null;
            $active = (bool) ($item['active'] ?? ($url === null));
            ?>
            <li class="breadcrumb-item <?= $active ? 'active' : '' ?>" <?= $active ? 'aria-current="page"' : '' ?>>
                <?php if (!$active && $url): ?>
                    <a href="<?= esc($url) ?>"><?= esc($label) ?></a>
                <?php else: ?>
                    <?= esc($label) ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>
