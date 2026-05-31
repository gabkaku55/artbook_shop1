<?php

$sqlitePath = $argv[1] ?? __DIR__ . '/../storage/app/temp-export/diploma.local/shop/database/database.sqlite';
$outputPath = $argv[2] ?? __DIR__ . '/../database/data/catalog.json';

if (! file_exists($sqlitePath)) {
    fwrite(STDERR, "SQLite not found: {$sqlitePath}\n");
    exit(1);
}

$db = new PDO('sqlite:' . $sqlitePath);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tables = $db->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);

$export = [
    'categories' => [],
    'products' => [],
    'unboxing_videos' => [],
];

if (in_array('categories', $tables, true)) {
    $export['categories'] = $db->query('SELECT * FROM categories ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
}

if (in_array('products', $tables, true)) {
    $export['products'] = $db->query('SELECT * FROM products ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
}

if (in_array('unboxing_videos', $tables, true)) {
    $export['unboxing_videos'] = $db->query('SELECT * FROM unboxing_videos ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
}

$dir = dirname($outputPath);
if (! is_dir($dir)) {
    mkdir($dir, 0755, true);
}

file_put_contents($outputPath, json_encode($export, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo 'Exported to ' . $outputPath . PHP_EOL;
echo 'categories: ' . count($export['categories']) . PHP_EOL;
echo 'products: ' . count($export['products']) . PHP_EOL;
echo 'unboxing_videos: ' . count($export['unboxing_videos']) . PHP_EOL;
