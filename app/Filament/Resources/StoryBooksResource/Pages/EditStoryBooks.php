<?php

namespace App\Filament\Resources\StorybooksResource\Pages;

use App\Filament\Resources\StorybooksResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorybooks extends EditRecord
{
    protected static string $resource = StorybooksResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
