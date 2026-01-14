<?= $this->extend('App\Views\layouts\frontend') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="/templates"><?= lang('Template.frontend.title') ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($item->title) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Ana Icerik -->
        <div class="col-lg-8">
            <article>
                <h1 class="mb-4"><?= esc($item->title) ?></h1>

                <div class="text-muted mb-4">
                    <small>
                        <i class="bi bi-calendar"></i>
                        <?= template_format_date($item->created_at, 'd.m.Y') ?>
                    </small>
                </div>

                <div class="content">
                    <?= nl2br(esc($item->description)) ?>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Ilgili Kayitlar -->
            <?php if (!empty($relatedItems)): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><?= lang('Template.frontend.related') ?></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($relatedItems as $related): ?>
                            <li class="list-group-item">
                                <a href="<?= template_url($related) ?>" class="text-decoration-none">
                                    <?= esc($related->title) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Geri Butonu -->
    <div class="mt-4">
        <a href="/templates" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> <?= lang('Template.buttons.back') ?>
        </a>
    </div>
</div>

<?= $this->endSection() ?>
