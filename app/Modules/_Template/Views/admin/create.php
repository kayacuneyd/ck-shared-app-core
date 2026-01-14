<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <a href="/admin/templates" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> <?= lang('Template.buttons.back') ?>
    </a>
</div>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="/admin/templates" method="post">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label"><?= lang('Template.fields.title') ?> *</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?= old('title') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="status" class="form-label"><?= lang('Template.fields.status') ?> *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="draft" <?= old('status') === 'draft' ? 'selected' : '' ?>>
                                <?= lang('Template.status_values.draft') ?>
                            </option>
                            <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>
                                <?= lang('Template.status_values.active') ?>
                            </option>
                            <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>
                                <?= lang('Template.status_values.inactive') ?>
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label"><?= lang('Template.fields.description') ?></label>
                <textarea class="form-control" id="description" name="description" rows="5"><?= old('description') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="sort_order" class="form-label"><?= lang('Template.fields.sort_order') ?></label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order"
                            value="<?= old('sort_order', 0) ?>" min="0">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                        <?= old('is_active', true) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">
                        <?= lang('Template.fields.is_active') ?>
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= lang('Template.buttons.save') ?></button>
                <a href="/admin/templates" class="btn btn-outline-secondary"><?= lang('Template.buttons.cancel') ?></a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
