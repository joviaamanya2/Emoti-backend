<?php

namespace App\Filament\Resources\StoryBooksResource\Pages;

use App\Filament\Resources\StoryBooksResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStoryBooks extends ListRecords
{
    protected static string $resource = StoryBooksResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
