<?php

namespace App\Filament\Resources\CounselorSessionLogResource\Pages;

use App\Filament\Resources\CounselorSessionLogResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCounselorSessionLog extends EditRecord
{
    protected static string $resource = CounselorSessionLogResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
