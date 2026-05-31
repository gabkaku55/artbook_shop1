<?php

declare(strict_types=1);

$outputPath = __DIR__ . '/../database/data/catalog.json';
$mysql = 'c:/OSPanel/modules/MySQL-8.0/bin/mysql.exe';

function runMysqlFile(string $mysql, string $sql): string
{
    $tmp = tempnam(sys_get_temp_dir(), 'catalog-export-');
    file_put_contents($tmp, $sql . PHP_EOL);

    $cmd = sprintf(
        '%s -u root --protocol=pipe --socket=MySQL-8.0 artbook_shop -N -B < %s',
        escapeshellarg($mysql),
        escapeshellarg($tmp)
    );

    $output = shell_exec('cmd /c ' . $cmd);
    unlink($tmp);

    return trim((string) $output);
}

function decodeJsonArray(string $json): array
{
    if ($json === '' || $json === 'NULL') {
        return [];
    }

    $decoded = json_decode($json, true);

    return is_array($decoded) ? $decoded : [];
}

$categoriesSql = "SELECT COALESCE(JSON_ARRAYAGG(JSON_OBJECT('name', name, 'name_en', name_en, 'name_de', name_de, 'slug', slug)), JSON_ARRAY()) FROM categories";

$productsSql = "SELECT COALESCE(JSON_ARRAYAGG(JSON_OBJECT('category_slug', (SELECT slug FROM categories c WHERE c.id = p.category_id), 'name', p.name, 'name_en', p.name_en, 'name_de', p.name_de, 'slug', p.slug, 'author', p.author, 'author_en', p.author_en, 'author_de', p.author_de, 'description', p.description, 'description_en', p.description_en, 'description_de', p.description_de, 'price', p.price, 'sale_price', p.sale_price, 'stock', p.stock, 'pages', p.pages, 'language', p.language, 'publisher', p.publisher, 'age_limit', p.age_limit, 'cover_type', p.cover_type, 'image', p.image, 'gallery', p.gallery, 'is_new', p.is_new, 'is_popular', p.is_popular)), JSON_ARRAY()) FROM products p";

$videosSql = "SELECT COALESCE(JSON_ARRAYAGG(JSON_OBJECT('title', title, 'description', description, 'video_path', video_path)), JSON_ARRAY()) FROM unboxing_videos";

$export = [
    'categories' => decodeJsonArray(runMysqlFile($mysql, $categoriesSql)),
    'products' => decodeJsonArray(runMysqlFile($mysql, $productsSql)),
    'unboxing_videos' => decodeJsonArray(runMysqlFile($mysql, $videosSql)),
];

$dir = dirname($outputPath);
if (! is_dir($dir)) {
    mkdir($dir, 0755, true);
}

file_put_contents($outputPath, json_encode($export, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo 'Exported to ' . $outputPath . PHP_EOL;
echo 'categories: ' . count($export['categories']) . PHP_EOL;
echo 'products: ' . count($export['products']) . PHP_EOL;
echo 'unboxing_videos: ' . count($export['unboxing_videos']) . PHP_EOL;
