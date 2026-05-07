<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Hashing\HashManager;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'admin';

        if (!empty($data['password'])) {
            $data['password'] = app(HashManager::class)->make($data['password']);
        }

        return $data;
    }
}

