<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure storage link exists
        $storageLink = public_path('storage');
        $storageTarget = storage_path('app/public');
        
        if (!file_exists($storageLink)) {
            try {
                // Try to create symlink
                if (is_link($storageLink)) {
                    // Remove broken symlink
                    unlink($storageLink);
                }
                \Illuminate\Support\Facades\Artisan::call('storage:link');
            } catch (\Exception $e) {
                // If symlink fails, try to create directory structure
                // This is a fallback for environments where symlinks don't work
                if (!file_exists($storageTarget)) {
                    \Illuminate\Support\Facades\File::makeDirectory($storageTarget, 0755, true);
                }
            }
        } elseif (is_link($storageLink) && !file_exists($storageLink)) {
            // Fix broken symlink
            try {
                unlink($storageLink);
                \Illuminate\Support\Facades\Artisan::call('storage:link');
            } catch (\Exception $e) {
                // Silently fail
            }
        }
    }
}
