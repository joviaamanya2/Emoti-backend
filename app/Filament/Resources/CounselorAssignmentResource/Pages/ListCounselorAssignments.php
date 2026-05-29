<?php

namespace App\Filament\Resources\CounselorAssignmentResource\Pages;

use App\Filament\Resources\CounselorAssignmentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCounselorAssignments extends ListRecords
{
    protected static string $resource = CounselorAssignmentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
