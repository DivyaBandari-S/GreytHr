<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CleanupLivewireTempFiles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->cleanupOldLivewireTempFiles();
        return $next($request);
    }
    protected function cleanupOldLivewireTempFiles()
    {
        $tempDir = storage_path('app/livewire-tmp');
        $files = File::files($tempDir);

        foreach ($files as $file) {
            $fileCreationTime = \Carbon\Carbon::createFromTimestamp($file->getCTime());
            if (now()->diffInMinutes($fileCreationTime)>60) {
                Log::info('Deleting old Livewire temp file:', ['file' => $file->getRealPath()]);
                File::delete($file);
            }
        }
    }
}