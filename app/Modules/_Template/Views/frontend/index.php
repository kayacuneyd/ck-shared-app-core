<?= $this->extend('App\Views\layouts\frontend') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <h1 class="mb-4"><?= esc($title) ?></h1>

    <!-- Arama Formu -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="/templates" method="get" class="d-flex">
                <input type="text" class="form-control me-2" name="search"
                    placeholder="<?= lang('Template.fields.title') ?>..."
                    value="<?= esc($search ?? '') ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <?php if (empty($items)): ?>
        <div class="alert alert-info">
            <?= lang('Template.frontend.no_items') ?>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($items as $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($item->title) ?></h5>
                            <p class="card-text text-muted">
                                <?= template_truncate($item->description ?? '', 100) ?>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="<?= template_url($item) ?>" class="btn btn-outline-primary btn-sm">
                                <?= lang('Template.buttons.view') ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Sayfalama -->
        <?php if (isset($pager)): ?>
            <div class="d-flex justify-content-center mt-4">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
