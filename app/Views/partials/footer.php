<?php

$footerText = $footerText ?? '';
$footerIcon = $footerIcon ?? '';
$prefix = $prefix ?? '';
$year = $year ?? date('Y');
?>

<footer>
    <div class="container text-center">
        <p>
            <?php if ($footerIcon): ?>
                <i class="bi <?= esc($footerIcon) ?> me-2"></i>
            <?php endif; ?>
            <?= esc($prefix) ?><?= esc($year) ?> <?= esc($footerText) ?>
        </p>
    </div>
</footer>
