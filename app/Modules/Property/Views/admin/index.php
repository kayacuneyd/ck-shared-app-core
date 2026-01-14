<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <a href="/admin/properties/create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> <?= lang('Property.admin.create') ?>
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
        <?php if (empty($properties)): ?>
            <p class="text-muted text-center py-4"><?= lang('Property.messages.no_properties') ?></p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= lang('Property.fields.title') ?></th>
                            <th><?= lang('Property.fields.city') ?></th>
                            <th><?= lang('Property.fields.price') ?></th>
                            <th><?= lang('Property.fields.status') ?></th>
                            <th><?= lang('Property.fields.featured') ?></th>
                            <th class="text-end"><?= lang('Property.admin.actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($properties as $property): ?>
                            <tr>
                                <td><?= esc($property->id) ?></td>
                                <td>
                                    <a href="/admin/properties/<?= esc($property->id) ?>">
                                        <?= esc($property->title) ?>
                                    </a>
                                </td>
                                <td><?= esc($property->city) ?></td>
                                <td><?= format_price($property->price) ?></td>
                                <td><?= property_status_badge($property->status) ?></td>
                                <td>
                                    <?php if ($property->featured): ?>
                                        <span class="badge bg-warning text-dark">★</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="/admin/properties/<?= esc($property->id) ?>"
                                        class="btn btn-sm btn-outline-secondary" title="<?= lang('Property.admin.view') ?>">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/admin/properties/<?= esc($property->id) ?>/edit"
                                        class="btn btn-sm btn-outline-primary" title="<?= lang('Property.admin.edit') ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="/admin/properties/<?= esc($property->id) ?>/delete" method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('<?= lang('Property.messages.confirm_delete') ?>');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="<?= lang('Property.admin.delete') ?>">
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