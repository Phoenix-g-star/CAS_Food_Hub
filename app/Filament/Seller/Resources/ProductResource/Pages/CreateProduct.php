<?php

namespace App\Filament\Seller\Resources\ProductResource\Pages;

use App\Filament\Seller\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        Log::info('Request data:', request()->all());
        Log::info('Request files:', request()->allFiles());

        $product = parent::handleRecordCreation($data);

        if (request()->hasFile('media')) {
            Log::info('Files:', request()->file('media'));

            foreach (request()->file('media') as $file) {
                Log::info('Processing file:', ['file' => $file->getClientOriginalName()]);
                $product->addMedia($file)->toMediaCollection('products');
            }
        } else {
            Log::warning('No media files found in the request.');
        }

        return $product;
    }
}
