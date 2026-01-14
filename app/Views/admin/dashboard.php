<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <h1>Welcome, <?= esc(session()->get('user_name')) ?>!</h1>
    <p>You are logged in.</p>
<?= $this->endSection() ?>
