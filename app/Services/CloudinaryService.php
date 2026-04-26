<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class CloudinaryService
{
    public function uploadImage(UploadedFile $file, string $folder): string
    {
        $cloudName = (string) env('CLOUDINARY_CLOUD_NAME');
        $apiKey = (string) env('CLOUDINARY_API_KEY');
        $apiSecret = (string) env('CLOUDINARY_API_SECRET');

        if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
            return $this->storeLocally($file, $folder);
        }

        $timestamp = time();
        $signature = sha1("folder={$folder}&timestamp={$timestamp}{$apiSecret}");

        $response = Http::asMultipart()
            ->attach('file', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
            ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'api_key' => $apiKey,
                'folder' => $folder,
                'timestamp' => $timestamp,
                'signature' => $signature,
            ]);

        $this->ensureUploadSucceeded($response);

        $secureUrl = $response->json('secure_url');

        if (! is_string($secureUrl) || $secureUrl === '') {
            throw new RuntimeException('Cloudinary did not return a secure URL.');
        }

        return $secureUrl;
    }

    private function storeLocally(UploadedFile $file, string $folder): string
    {
        $directory = 'uploads/'.trim((string) Str::of($folder)
            ->replace('\\', '/')
            ->replace(' ', '-')
            ->lower(), '/');

        $path = $file->store($directory, 'public');

        if (! is_string($path) || $path === '') {
            throw new RuntimeException('Local image upload failed.');
        }

        return 'storage/'.$path;
    }

    private function ensureUploadSucceeded(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        $message = $response->json('error.message') ?: 'Cloudinary upload failed.';

        throw new RuntimeException($message);
    }
}
