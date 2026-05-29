<?php

namespace App\Filament\Resources\StorybooksResource\Pages;

use App\Filament\Resources\StorybooksResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStorybooks extends ListRecords
{
    protected static string $resource = StorybooksResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
