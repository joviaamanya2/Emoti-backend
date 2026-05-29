<?php

namespace App\Filament\Resources\CounselorSessionResource\Pages;

use App\Filament\Resources\CounselorSessionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSession extends EditRecord
{
    protected static string $resource = CounselorSessionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
