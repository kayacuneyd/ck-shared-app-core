<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <a href="/admin/properties" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> <?= lang('Property.admin.back') ?>
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
        <form action="/admin/properties" method="post">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label"><?= lang('Property.fields.title') ?> *</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>"
                            required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="status" class="form-label"><?= lang('Property.fields.status') ?> *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="available" <?= old('status') === 'available' ? 'selected' : '' ?>>
                                <?= lang('Property.status.available') ?></option>
                            <option value="reserved" <?= old('status') === 'reserved' ? 'selected' : '' ?>>
                                <?= lang('Property.status.reserved') ?></option>
                            <option value="sold" <?= old('status') === 'sold' ? 'selected' : '' ?>>
                                <?= lang('Property.status.sold') ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label"><?= lang('Property.fields.description') ?> *</label>
                <textarea class="form-control" id="description" name="description" rows="5"
                    required><?= old('description') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="price" class="form-label"><?= lang('Property.fields.price') ?> (€) *</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?= old('price') ?>"
                            step="0.01" min="0" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="area_sqm" class="form-label"><?= lang('Property.fields.area_sqm') ?></label>
                        <input type="number" class="form-control" id="area_sqm" name="area_sqm"
                            value="<?= old('area_sqm') ?>" step="0.01" min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="bedrooms" class="form-label"><?= lang('Property.fields.bedrooms') ?></label>
                        <input type="number" class="form-control" id="bedrooms" name="bedrooms"
                            value="<?= old('bedrooms') ?>" min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="bathrooms" class="form-label"><?= lang('Property.fields.bathrooms') ?></label>
                        <input type="number" class="form-control" id="bathrooms" name="bathrooms"
                            value="<?= old('bathrooms') ?>" min="0">
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="address" class="form-label"><?= lang('Property.fields.address') ?> *</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="<?= old('address') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="city" class="form-label"><?= lang('Property.fields.city') ?> *</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?= old('city') ?>"
                            required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="zip_code" class="form-label"><?= lang('Property.fields.zip_code') ?> *</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code"
                            value="<?= old('zip_code') ?>" required>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                        <?= old('featured') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="featured">
                        <?= lang('Property.fields.featured') ?>
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= lang('Property.admin.save') ?></button>
                <a href="/admin/properties" class="btn btn-outline-secondary"><?= lang('Property.admin.cancel') ?></a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>