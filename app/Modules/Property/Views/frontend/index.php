<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title"><?= lang('Property.frontend.title') ?></h1>
                <p class="hero-subtitle">
                    <?= lang('Property.frontend.subtitle') ?? 'Finden Sie Ihre Traumimmobilie in Baden-Württemberg' ?>
                </p>
            </div>
            <div class="col-lg-6">
                <div class="d-flex gap-3 justify-content-lg-end mt-4 mt-lg-0">
                    <div class="text-center px-4">
                        <div class="fs-2 fw-bold"><?= count($properties ?? []) ?>+</div>
                        <div class="small opacity-75">Immobilien</div>
                    </div>
                    <div class="border-start border-light opacity-25"></div>
                    <div class="text-center px-4">
                        <div class="fs-2 fw-bold"><?= count($cities ?? []) ?></div>
                        <div class="small opacity-75">Städte</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Search Card -->
    <div class="search-card animate-fadeInUp">
        <form method="get" action="/properties">
            <div class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label class="form-label text-muted small mb-2">
                        <i class="bi bi-search me-1"></i> <?= lang('Property.frontend.search') ?>
                    </label>
                    <input type="text" class="form-control form-control-lg" name="q"
                        placeholder="<?= lang('Property.frontend.search_placeholder') ?>"
                        value="<?= esc($search ?? '') ?>">
                </div>
                <div class="col-lg-4">
                    <label class="form-label text-muted small mb-2">
                        <i class="bi bi-geo-alt me-1"></i> <?= lang('Property.frontend.city') ?>
                    </label>
                    <select class="form-select form-select-lg" name="city">
                        <option value=""><?= lang('Property.frontend.all_cities') ?></option>
                        <?php foreach ($cities ?? [] as $c): ?>
                            <option value="<?= esc($c) ?>" <?= ($city ?? '') === $c ? 'selected' : '' ?>>
                                <?= esc($c) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-search me-2"></i><?= lang('Property.frontend.search') ?>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Properties Grid -->
    <?php if (empty($properties)): ?>
        <div class="text-center py-5">
            <i class="bi bi-house-slash display-1 text-muted mb-4"></i>
            <h3 class="text-muted"><?= lang('Property.frontend.no_properties') ?></h3>
            <p class="text-muted"><?= lang('Property.frontend.try_different_search') ?? 'Versuchen Sie eine andere Suche' ?>
            </p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($properties as $index => $property): ?>
                <div class="col-md-6 col-lg-4 animate-fadeInUp delay-<?= ($index % 3) + 1 ?>">
                    <div class="property-card">
                        <!-- Property Image -->
                        <div class="property-image">
                            <i class="bi bi-building"></i>

                            <?php if ($property->featured): ?>
                                <span class="property-badge badge-featured">
                                    <i class="bi bi-star-fill me-1"></i><?= lang('Property.featured') ?>
                                </span>
                            <?php else: ?>
                                <span class="property-badge badge-<?= $property->status ?>">
                                    <?= lang('Property.status.' . $property->status) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Property Body -->
                        <div class="property-body">
                            <h5 class="property-title"><?= esc($property->title) ?></h5>
                            <p class="property-location">
                                <i class="bi bi-geo-alt-fill me-1"></i>
                                <?= esc($property->city) ?>
                            </p>

                            <div class="property-price">
                                <?= format_price($property->price) ?>
                            </div>

                            <div class="property-features">
                                <div class="feature-item">
                                    <i class="bi bi-door-open"></i>
                                    <span><?= esc($property->bedrooms) ?>         <?= lang('Property.fields.bedrooms') ?></span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-droplet"></i>
                                    <span><?= esc($property->bathrooms) ?>         <?= lang('Property.fields.bathrooms') ?></span>
                                </div>
                                <div class="feature-item">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                    <span><?= esc($property->area_sqm) ?> m²</span>
                                </div>
                            </div>

                            <a href="/properties/<?= esc($property->slug) ?>" class="btn btn-primary w-100 mt-3">
                                <i class="bi bi-eye me-2"></i><?= lang('Property.frontend.view_details') ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($pager)): ?>
            <?= view('components/pagination', [
                'pager' => $pager,
                'wrapperClass' => 'd-flex justify-content-center mt-5',
            ]) ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
