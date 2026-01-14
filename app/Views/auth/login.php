<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2><?= lang('Auth.login.title') ?></h2>
        <?= view('components/alerts') ?>
        <form action="/login" method="post">
            <?= csrf_field() ?>
            <?= view('components/form_field', [
                'name' => 'email',
                'type' => 'email',
                'label' => lang('Auth.login.email'),
                'value' => old('email'),
                'required' => true,
                'attributes' => ['autocomplete' => 'email'],
            ]) ?>
            <?= view('components/form_field', [
                'name' => 'password',
                'type' => 'password',
                'label' => lang('Auth.login.password'),
                'value' => '',
                'required' => true,
                'attributes' => ['autocomplete' => 'current-password'],
            ]) ?>
            <button type="submit" class="btn btn-primary"><?= lang('Auth.login.submit') ?></button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
