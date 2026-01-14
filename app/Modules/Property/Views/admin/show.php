<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($property->title) ?></h1>
    <div class="d-flex gap-2">
        <a href="/admin/properties/<?= esc($property->id) ?>/edit" class="btn btn-primary">
            <i class="bi bi-pencil"></i> <?= lang('Property.admin.edit') ?>
        </a>
        <a href="/admin/properties" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> <?= lang('Property.admin.back') ?>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('Property.admin.details') ?></h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong><?= lang('Property.fields.description') ?></strong>
                    <p class="mt-2"><?= nl2br(esc($property->description)) ?></p>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong><?= lang('Property.fields.address') ?>:</strong><br><?= esc($property->address) ?>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p><strong><?= lang('Property.fields.city') ?>:</strong><br><?= esc($property->city) ?></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong><?= lang('Property.fields.zip_code') ?>:</strong><br><?= esc($property->zip_code) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('Property.admin.info') ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th><?= lang('Property.fields.price') ?>:</th>
                        <td class="text-end"><?= format_price($property->price) ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('Property.fields.area_sqm') ?>:</th>
                        <td class="text-end">
                            <?= $property->area_sqm ? number_format($property->area_sqm, 2) . ' m²' : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('Property.fields.bedrooms') ?>:</th>
                        <td class="text-end"><?= $property->bedrooms ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('Property.fields.bathrooms') ?>:</th>
                        <td class="text-end"><?= $property->bathrooms ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('Property.fields.status') ?>:</th>
                        <td class="text-end"><?= property_status_badge($property->status) ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('Property.fields.featured') ?>:</th>
                        <td class="text-end">
                            <?php if ($property->featured): ?>
                                <span class="badge bg-warning text-dark">★ <?= lang('Property.yes') ?></span>
                            <?php else: ?>
                                <span class="text-muted"><?= lang('Property.no') ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('Property.admin.meta') ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th>ID:</th>
                        <td class="text-end"><?= esc($property->id) ?></td>
                    </tr>
                    <tr>
                        <th>Slug:</th>
                        <td class="text-end"><code><?= esc($property->slug) ?></code></td>
                    </tr>
                    <tr>
                        <th><?= lang('Property.fields.created_at') ?>:</th>
                        <td class="text-end"><?= $property->created_at->format('d.m.Y H:i') ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('Property.fields.updated_at') ?>:</th>
                        <td class="text-end">
                            <?= $property->updated_at ? $property->updated_at->format('d.m.Y H:i') : '-' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>