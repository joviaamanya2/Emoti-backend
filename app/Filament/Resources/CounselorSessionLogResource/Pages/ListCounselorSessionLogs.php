<?php

namespace App\Filament\Resources\CounselorSessionLogResource\Pages;

use App\Filament\Resources\CounselorSessionLogResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCounselorSessionLogs extends ListRecords
{
    protected static string $resource = CounselorSessionLogResource::class;

    protected function getActions(): array
    {
        return [
            // No create action — logs are submitted from the mobile app
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }

    protected function getTitle(): string
    {
        return 'Counselor Session Logs';
    }
}