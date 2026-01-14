<?= $this->extend('App\Views\layouts\frontend') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <?= view('components/breadcrumb', [
        'containerClass' => 'mb-4',
        'items' => [
            ['label' => lang('Property.frontend.home'), 'url' => '/'],
            ['label' => lang('Property.frontend.title'), 'url' => '/properties'],
            ['label' => $property->title, 'active' => true],
        ],
    ]) ?>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Property Image -->
            <div class="card mb-4">
                <img src="<?= esc($property->getMainImage()) ?>" class="card-img-top" alt="<?= esc($property->title) ?>"
                    style="max-height: 450px; object-fit: cover;">
            </div>

            <!-- Description -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><?= lang('Property.fields.description') ?></h5>
                </div>
                <div class="card-body">
                    <?= nl2br(esc($property->description)) ?>
                </div>
            </div>

            <!-- Location -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><?= lang('Property.frontend.location') ?></h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        <i class="bi bi-geo-alt"></i>
                        <?= esc($property->address) ?><br>
                        <?= esc($property->zip_code) ?> <?= esc($property->city) ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Title & Price Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-2"><?= esc($property->title) ?></h2>
                    <p class="text-muted mb-3">
                        <i class="bi bi-geo-alt"></i> <?= esc($property->city) ?>
                    </p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <?= property_status_badge($property->status) ?>
                        <?php if ($property->featured): ?>
                            <span class="badge bg-warning text-dark">★ Featured</span>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <h3 class="text-primary mb-0"><?= format_price($property->price) ?></h3>
                </div>
            </div>

            <!-- Property Details Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><?= lang('Property.frontend.details') ?></h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <?php if ($property->area_sqm): ?>
                            <tr>
                                <th><i class="bi bi-arrows-move"></i> <?= lang('Property.fields.area_sqm') ?></th>
                                <td class="text-end"><?= number_format($property->area_sqm, 2) ?> m²</td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($property->bedrooms): ?>
                            <tr>
                                <th><i class="bi bi-door-open"></i> <?= lang('Property.fields.bedrooms') ?></th>
                                <td class="text-end"><?= esc($property->bedrooms) ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($property->bathrooms): ?>
                            <tr>
                                <th><i class="bi bi-droplet"></i> <?= lang('Property.fields.bathrooms') ?></th>
                                <td class="text-end"><?= esc($property->bathrooms) ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><?= lang('Property.frontend.contact') ?></h5>
                </div>
                <div class="card-body">
                    <p class="text-muted"><?= lang('Property.frontend.contact_text') ?></p>
                    <a href="mailto:info@example.com" class="btn btn-primary w-100">
                        <i class="bi bi-envelope"></i> <?= lang('Property.frontend.send_inquiry') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Properties -->
    <?php if (!empty($related)): ?>
        <hr class="my-5">
        <h3 class="mb-4"><?= lang('Property.frontend.related') ?></h3>
        <div class="row">
            <?php foreach ($related as $relatedProperty): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= esc($relatedProperty->getMainImage()) ?>" class="card-img-top"
                            alt="<?= esc($relatedProperty->title) ?>" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($relatedProperty->title) ?></h5>
                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt"></i> <?= esc($relatedProperty->city) ?>
                            </p>
                            <strong class="text-primary"><?= format_price($relatedProperty->price) ?></strong>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="/properties/<?= esc($relatedProperty->slug) ?>"
                                class="btn btn-outline-primary btn-sm w-100">
                                <?= lang('Property.frontend.view_details') ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
