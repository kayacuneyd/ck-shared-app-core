<?php

$pager = $pager ?? null;
if ($pager === null) {
    return;
}

$group = $group ?? 'default';
$template = $template ?? 'default_full';
$wrapperClass = $wrapperClass ?? 'd-flex justify-content-center mt-4';
?>

<div class="<?= esc($wrapperClass) ?>">
    <?= $pager->links($group, $template) ?>
</div>
