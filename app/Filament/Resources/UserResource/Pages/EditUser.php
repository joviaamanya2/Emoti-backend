<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Hashing\HashManager;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (array_key_exists('password', $data) && !empty($data['password'])) {
            $data['password'] = app(HashManager::class)->make($data['password']);
        } else {
            unset($data['password']);
        }

        return $data;
    }
}

