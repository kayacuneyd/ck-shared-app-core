<?php

/**
 * CK Shared App Core - Release Build Script
 *
 * Bu script, production-ready bir release ZIP dosyasi olusturur.
 * vendor/ klasoru dahil edilir, boylece SSH olmayan hosting'lerde
 * direkt FTP ile deploy edilebilir.
 *
 * Kullanim:
 *   php scripts/build-release.php [version]
 *
 * Ornekler:
 *   php scripts/build-release.php           # composer.json'dan versiyon alir
 *   php scripts/build-release.php 1.0.0     # manuel versiyon belirt
 *
 * Cikti:
 *   releases/ck-shared-app-core-v1.0.0.zip
 */

// Ayarlar
define('ROOT_DIR', dirname(__DIR__));
define('RELEASES_DIR', ROOT_DIR . '/releases');
define('PROJECT_NAME', 'ck-shared-app-core');

// Renk kodlari (terminal icin)
function info($message)
{
    echo "\033[34m[INFO]\033[0m $message\n";
}

function success($message)
{
    echo "\033[32m[OK]\033[0m $message\n";
}

function error($message)
{
    echo "\033[31m[ERROR]\033[0m $message\n";
}

function warning($message)
{
    echo "\033[33m[WARN]\033[0m $message\n";
}

// Versiyon al
function getVersion($argv)
{
    // Komut satirindan versiyon verilmisse
    if (isset($argv[1]) && preg_match('/^\d+\.\d+\.\d+$/', $argv[1])) {
        return $argv[1];
    }

    // composer.json'dan oku
    $composerFile = ROOT_DIR . '/composer.json';
    if (file_exists($composerFile)) {
        $composer = json_decode(file_get_contents($composerFile), true);
        if (isset($composer['version'])) {
            return $composer['version'];
        }
    }

    // Varsayilan
    return '1.0.0';
}

// Klasor kopyalama (recursive)
function copyDirectory($src, $dst, $excludes = [])
{
    if (!is_dir($src)) {
        return false;
    }

    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }

    $dir = opendir($src);
    while (($file = readdir($dir)) !== false) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        // Exclude kontrolu
        foreach ($excludes as $exclude) {
            if (fnmatch($exclude, $file)) {
                continue 2;
            }
        }

        $srcPath = $src . '/' . $file;
        $dstPath = $dst . '/' . $file;

        if (is_dir($srcPath)) {
            copyDirectory($srcPath, $dstPath, $excludes);
        } else {
            copy($srcPath, $dstPath);
        }
    }
    closedir($dir);

    return true;
}

// Klasor silme (recursive)
function deleteDirectory($dir)
{
    if (!is_dir($dir)) {
        return;
    }

    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        is_dir($path) ? deleteDirectory($path) : unlink($path);
    }
    rmdir($dir);
}

// ZIP olustur
function createZip($source, $destination)
{
    if (!extension_loaded('zip')) {
        error("ZIP extension yuklu degil!");
        return false;
    }

    $zip = new ZipArchive();
    if ($zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        error("ZIP dosyasi olusturulamadi: $destination");
        return false;
    }

    $source = realpath($source);
    $baseName = basename($source);

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $file) {
        $filePath = $file->getRealPath();
        $relativePath = $baseName . '/' . substr($filePath, strlen($source) + 1);

        if ($file->isDir()) {
            $zip->addEmptyDir($relativePath);
        } else {
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();
    return true;
}

// Ana islem
function main($argv)
{
    echo "\n";
    echo "╔══════════════════════════════════════════╗\n";
    echo "║  CK Shared App Core - Release Builder    ║\n";
    echo "╚══════════════════════════════════════════╝\n";
    echo "\n";

    // Versiyon
    $version = getVersion($argv);
    info("Versiyon: v$version");

    // Releases klasoru olustur
    if (!is_dir(RELEASES_DIR)) {
        mkdir(RELEASES_DIR, 0755, true);
        success("releases/ klasoru olusturuldu");
    }

    // Gecici klasor
    $tempDir = RELEASES_DIR . '/temp-' . uniqid();
    $releaseDir = $tempDir . '/' . PROJECT_NAME . '-v' . $version;
    mkdir($releaseDir, 0755, true);
    info("Gecici klasor olusturuldu");

    // Kopyalanacak dosya ve klasorler
    $includes = [
        'app',
        'public',
        'writable',
        'composer.json',
        'composer.lock',
        'spark',
        '.htaccess',
        '.env.example',
        'README.md',
        'DEPLOYMENT.md',
        'CLAUDE.md',
        'PROMPTS.md',
        'LICENSE',
    ];

    // Haric tutulacaklar
    $excludes = [
        '.git',
        '.gitignore',
        '.idea',
        '.vscode',
        'node_modules',
        'releases',
        'scripts',
        'tests',
        '.env',
        '*.sqlite',
        '*.sqlite3',
        '*.log',
    ];

    // Dosyalari kopyala
    info("Dosyalar kopyalaniyor...");
    foreach ($includes as $item) {
        $src = ROOT_DIR . '/' . $item;
        $dst = $releaseDir . '/' . $item;

        if (!file_exists($src)) {
            warning("Bulunamadi: $item");
            continue;
        }

        if (is_dir($src)) {
            copyDirectory($src, $dst, $excludes);
        } else {
            $dstDir = dirname($dst);
            if (!is_dir($dstDir)) {
                mkdir($dstDir, 0755, true);
            }
            copy($src, $dst);
        }
    }
    success("Dosyalar kopyalandi");

    // Vendor klasorunu olustur (composer install)
    info("Composer install calistiriliyor (production)...");
    $composerCmd = sprintf(
        'cd "%s" && composer install --no-dev --optimize-autoloader --no-interaction 2>&1',
        $releaseDir
    );
    exec($composerCmd, $output, $returnCode);

    if ($returnCode !== 0) {
        error("Composer install basarisiz!");
        echo implode("\n", $output) . "\n";
        deleteDirectory($tempDir);
        return 1;
    }
    success("Composer install tamamlandi");

    // Writable klasorlerini olustur
    $writableDirs = ['database', 'cache', 'logs', 'session'];
    foreach ($writableDirs as $dir) {
        $path = $releaseDir . '/writable/' . $dir;
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        // .gitkeep ekle
        file_put_contents($path . '/.gitkeep', '');
    }
    success("Writable klasorleri hazir");

    // Gereksiz dosyalari temizle
    $cleanupPatterns = [
        $releaseDir . '/writable/database/*.sqlite',
        $releaseDir . '/writable/logs/*.log',
        $releaseDir . '/writable/cache/*',
        $releaseDir . '/writable/session/*',
    ];
    foreach ($cleanupPatterns as $pattern) {
        foreach (glob($pattern) as $file) {
            if (basename($file) !== '.gitkeep') {
                unlink($file);
            }
        }
    }

    // ZIP olustur
    $zipFile = RELEASES_DIR . '/' . PROJECT_NAME . '-v' . $version . '.zip';
    info("ZIP olusturuluyor: " . basename($zipFile));

    if (file_exists($zipFile)) {
        unlink($zipFile);
        warning("Mevcut ZIP silindi");
    }

    if (createZip($tempDir . '/' . PROJECT_NAME . '-v' . $version, $zipFile)) {
        success("ZIP olusturuldu!");
    } else {
        error("ZIP olusturulamadi!");
        deleteDirectory($tempDir);
        return 1;
    }

    // Gecici klasoru temizle
    deleteDirectory($tempDir);
    success("Gecici dosyalar temizlendi");

    // Sonuc
    $zipSize = round(filesize($zipFile) / 1024 / 1024, 2);
    echo "\n";
    echo "╔══════════════════════════════════════════╗\n";
    echo "║  Release basariyla olusturuldu!          ║\n";
    echo "╚══════════════════════════════════════════╝\n";
    echo "\n";
    success("Dosya: releases/" . basename($zipFile));
    success("Boyut: {$zipSize} MB");
    echo "\n";
    info("Sonraki adimlar:");
    echo "  1. ZIP'i GitHub Releases'e yukleyin\n";
    echo "  2. veya FTP ile direkt hosting'e yukleyin\n";
    echo "  3. .env dosyasini olusturun\n";
    echo "  4. Migration calistirin: php spark migrate --all\n";
    echo "\n";

    return 0;
}

// Calistir
exit(main($argv));
