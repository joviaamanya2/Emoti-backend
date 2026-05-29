<?php

namespace App\Filament\Resources\CounselorSessionResource\Pages;

use App\Filament\Resources\CounselorSessionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSessions extends ListRecords
{
    protected static string $resource = CounselorSessionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
