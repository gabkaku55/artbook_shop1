<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncCatalogMedia extends Command
{
    protected $signature = 'catalog:sync-media';

    protected $description = 'Copy bundled product images and videos from database/media to public paths';

    public function handle(): int
    {
        $sourceRoot = database_path('media');
        if (! is_dir($sourceRoot)) {
            $this->warn('database/media not found, skipping.');

            return self::SUCCESS;
        }

        $products = $this->copyDirectory("{$sourceRoot}/products", storage_path('app/public/products'));
        $videos = $this->copyDirectory("{$sourceRoot}/video", public_path('video'));

        $this->info("Synced {$products} product images and {$videos} videos.");

        return self::SUCCESS;
    }

    private function copyDirectory(string $from, string $to): int
    {
        if (! is_dir($from)) {
            return 0;
        }

        File::ensureDirectoryExists($to);
        $count = 0;

        foreach (File::files($from) as $file) {
            $target = $to . DIRECTORY_SEPARATOR . $file->getFilename();
            if (! file_exists($target)) {
                File::copy($file->getPathname(), $target);
            }
            $count++;
        }

        return $count;
    }
}
