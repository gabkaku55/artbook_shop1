<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$mediaRoot = $root . '/database/media';

$maps = [
    $root . '/storage/app/public/products' => $mediaRoot . '/products',
    $root . '/public/video' => $mediaRoot . '/video',
];

foreach ($maps as $from => $to) {
    if (! is_dir($from)) {
        echo "Skip missing: {$from}\n";
        continue;
    }

    if (! is_dir($to)) {
        mkdir($to, 0755, true);
    }

    $count = 0;
    foreach (scandir($from) as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $source = $from . DIRECTORY_SEPARATOR . $file;
        if (! is_file($source)) {
            continue;
        }

        $target = $to . DIRECTORY_SEPARATOR . $file;
        if (! file_exists($target)) {
            copy($source, $target);
        }
        $count++;
    }

    echo "Synced {$count} files to {$to}\n";
}
