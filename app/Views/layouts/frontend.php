<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Premium Immobilien in Baden-Wurttemberg">
    <title><?= $title ?? 'BaWue Makler - Premium Immobilien' ?></title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/app.css">
</head>

<body>
    <?php
    $navbarItems = [
        ['href' => '/', 'icon' => 'bi-house', 'label' => 'Home'],
        ['href' => '/properties', 'icon' => 'bi-grid-3x3-gap', 'label' => 'Immobilien'],
    ];
    ?>
    <?= view('partials/navbar', [
        'brand' => 'BaWue Makler',
        'brandUrl' => '/',
        'brandIcon' => 'bi-building',
        'navItems' => $navbarItems,
        'loginUrl' => '/login',
        'loginLabel' => 'Login',
        'loginIcon' => 'bi-person-circle',
    ]) ?>

    <!-- Spacer for fixed navbar -->
    <div style="height: 76px;"></div>

    <!-- Main Content -->
    <?= $this->renderSection('content') ?>

    <?= view('partials/footer', [
        'footerIcon' => 'bi-building',
        'prefix' => '(c) ',
        'footerText' => 'BaWue Makler - Premium Immobilien in Baden-Wurttemberg',
    ]) ?>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
