<?php

namespace App\Filament\Resources\CounselorAssignmentResource\Pages;

use App\Filament\Resources\CounselorAssignmentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCounselorAssignment extends EditRecord
{
    protected static string $resource = CounselorAssignmentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
