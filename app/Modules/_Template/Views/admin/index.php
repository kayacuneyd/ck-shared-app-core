<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <a href="/admin/templates/create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> <?= lang('Template.buttons.create') ?>
    </a>
</div>

<?php if (session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <?php if (empty($items)): ?>
            <p class="text-muted text-center py-4"><?= lang('Template.frontend.no_items') ?></p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= lang('Template.fields.title') ?></th>
                            <th><?= lang('Template.fields.status') ?></th>
                            <th><?= lang('Template.fields.is_active') ?></th>
                            <th><?= lang('Template.fields.sort_order') ?></th>
                            <th><?= lang('Template.fields.created_at') ?></th>
                            <th class="text-end"><?= lang('Template.buttons.edit') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= esc($item->id) ?></td>
                                <td>
                                    <a href="/admin/templates/<?= esc($item->id) ?>">
                                        <?= esc($item->title) ?>
                                    </a>
                                </td>
                                <td><?= template_status_badge($item->status) ?></td>
                                <td><?= template_active_badge($item->is_active) ?></td>
                                <td><?= esc($item->sort_order) ?></td>
                                <td><?= template_format_date($item->created_at) ?></td>
                                <td class="text-end">
                                    <a href="/admin/templates/<?= esc($item->id) ?>"
                                        class="btn btn-sm btn-outline-secondary" title="<?= lang('Template.buttons.view') ?>">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/admin/templates/<?= esc($item->id) ?>/edit"
                                        class="btn btn-sm btn-outline-primary" title="<?= lang('Template.buttons.edit') ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="/admin/templates/<?= esc($item->id) ?>/delete" method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('<?= lang('Template.messages.delete_confirm') ?>');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="<?= lang('Template.buttons.delete') ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
