<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CounselorSessionResource\Pages;
use App\Models\CounselorSession;
use App\Models\Counselor;

use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;

use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class CounselorSessionResource extends Resource
{
    protected static ?string $model = CounselorSession::class;

    // protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Counseling Management';

    // Disable creation completely
    public static function canCreate(): bool
    {
        return false;
    }

    // Disable create/edit forms
    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scheduled_at')
                    ->label('Scheduled Time')
                    ->dateTime('M d, Y | h:i A')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Patient')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('counselor.name')
                    ->label('Counselor')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'scheduled',
                        'warning' => 'ongoing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->enum([
                        'scheduled' => 'Scheduled',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Done',
                        'cancelled' => 'Cancelled',
                    ]),

                ImageColumn::make('session_screenshot')
                    ->label('Screenshot')
                    ->circular()
                    ->toggleable(true),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Done',
                        'cancelled' => 'Cancelled',
                    ]),

                SelectFilter::make('counselor_id')
                    ->label('Filter by Counselor')
                    ->options(
                        Counselor::query()->pluck('name', 'id')->toArray()
                    ),
            ])

            // Disable row actions
            ->actions([])

            // Disable bulk actions
            ->bulkActions([])

            ->defaultSort('scheduled_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSessions::route('/'),
        ];
    }
}