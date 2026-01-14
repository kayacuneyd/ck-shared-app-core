<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <div>
        <a href="/admin/templates/<?= esc($item->id) ?>/edit" class="btn btn-primary">
            <i class="bi bi-pencil"></i> <?= lang('Template.buttons.edit') ?>
        </a>
        <a href="/admin/templates" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> <?= lang('Template.buttons.back') ?>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px;"><?= lang('Template.fields.title') ?></th>
                <td><?= esc($item->title) ?></td>
            </tr>
            <tr>
                <th><?= lang('Template.fields.slug') ?></th>
                <td><code><?= esc($item->slug) ?></code></td>
            </tr>
            <tr>
                <th><?= lang('Template.fields.description') ?></th>
                <td><?= nl2br(esc($item->description)) ?></td>
            </tr>
            <tr>
                <th><?= lang('Template.fields.status') ?></th>
                <td><?= template_status_badge($item->status) ?></td>
            </tr>
            <tr>
                <th><?= lang('Template.fields.is_active') ?></th>
                <td><?= template_active_badge($item->is_active) ?></td>
            </tr>
            <tr>
                <th><?= lang('Template.fields.sort_order') ?></th>
                <td><?= esc($item->sort_order) ?></td>
            </tr>
            <tr>
                <th><?= lang('Template.fields.created_at') ?></th>
                <td><?= template_format_date($item->created_at) ?></td>
            </tr>
            <tr>
                <th><?= lang('Template.fields.updated_at') ?></th>
                <td><?= template_format_date($item->updated_at) ?></td>
            </tr>
        </table>

        <div class="mt-4">
            <form action="/admin/templates/<?= esc($item->id) ?>/delete" method="post"
                onsubmit="return confirm('<?= lang('Template.messages.delete_confirm') ?>');">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> <?= lang('Template.buttons.delete') ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
