<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Premium Immobilien in Baden-Württemberg">
    <title><?= $title ?? 'BaWue Makler - Premium Immobilien' ?></title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --dark-bg: #0f172a;
            --card-bg: #1e293b;
            --text-muted: #94a3b8;
            --accent: #818cf8;
            --success: #10b981;
            --warning: #f59e0b;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--dark-bg);
            color: #f1f5f9;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: #cbd5e1 !important;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--accent) !important;
        }

        /* Hero Section */
        .hero-section {
            background: var(--primary-gradient);
            padding: 4rem 0;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Property Cards */
        .property-card {
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .property-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: var(--accent);
        }

        .property-image {
            height: 200px;
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .property-image i {
            font-size: 4rem;
            color: #4b5563;
        }

        .property-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-featured {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #000;
        }

        .badge-available {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .badge-reserved {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
            border: 1px solid var(--warning);
        }

        .badge-sold {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid #ef4444;
        }

        .property-body {
            padding: 1.5rem;
        }

        .property-title {
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #f1f5f9;
        }

        .property-location {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .property-location i {
            color: var(--accent);
        }

        .property-price {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .property-features {
            display: flex;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .feature-item i {
            color: var(--accent);
        }

        /* Search Form */
        .search-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .form-control,
        .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f1f5f9;
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.2);
            color: #f1f5f9;
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-outline-light {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
        }

        /* Footer */
        footer {
            background: var(--card-bg);
            padding: 2rem 0;
            margin-top: 4rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        footer p {
            color: var(--text-muted);
            margin: 0;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-building me-2"></i>BaWue Makler
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="bi bi-house me-1"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/properties"><i class="bi bi-grid-3x3-gap me-1"></i> Immobilien</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="/login">
                            <i class="bi bi-person-circle me-1"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Spacer for fixed navbar -->
    <div style="height: 76px;"></div>

    <!-- Main Content -->
    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p><i class="bi bi-building me-2"></i> © <?= date('Y') ?> BaWue Makler - Premium Immobilien in
                Baden-Württemberg</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>