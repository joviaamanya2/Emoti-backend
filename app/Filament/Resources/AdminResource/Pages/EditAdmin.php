<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Hashing\HashManager;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['role'] = 'admin';

        if (array_key_exists('password', $data) && !empty($data['password'])) {
            $data['password'] = app(HashManager::class)->make($data['password']);
        } else {
            unset($data['password']);
        }

        return $data;
    }
}

