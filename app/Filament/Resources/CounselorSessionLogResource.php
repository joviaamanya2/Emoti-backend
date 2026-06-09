<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CounselorSessionLogResource\Pages;
use App\Models\CounselorSessionLog;
use App\Models\User;

use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;

use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class CounselorSessionLogResource extends Resource
{
    protected static ?string $model = CounselorSessionLog::class;

   protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';
    protected static ?string $navigationGroup = 'Counseling Management';

    protected static ?string $navigationLabel = 'Session Logs';

    protected static ?int $navigationSort = 2;

    // Disable creation — logs come from the app
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Submitted On')
                    ->dateTime('M d, Y | h:i A')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('counselor_name')
                    ->label('Counselor')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->counselor_email),

                TextColumn::make('counselor_contact')
                    ->label('Contact')
                    ->searchable()
                    ->toggleable(true),
                    // ->toggleableByDefault(false),

                TextColumn::make('client_name')
                    ->label('Client / Patient')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                BadgeColumn::make('specification')
                    ->label('Category')
                    ->colors([
                        'primary' => 'Anxiety',
                        'warning' => 'Depression',
                        'danger' => 'PTSD',
                        'success' => 'Stress',
                        'secondary' => 'Relationship',
                        'info' => 'Grief',
                    ])
                    ->searchable()
                    ->sortable(),

                TextColumn::make('session_notes')
                    ->label('Notes')
                    ->limit(50)
                    ->wrap()
                    ->toggleable()
                    ->tooltip(fn ($record) => $record->session_notes),

                ImageColumn::make('screenshot_path')
                    ->label('Screenshot')
                    ->disk('public')
                    ->circular()
                    ->toggleable()
                    ->size(40),

                TextColumn::make('counselor_id')
                    ->label('Counselor ID')
                    ->toggleable(true)
                    // ->toggleableByDefault(false)
                    ->searchable(),
            ])

            ->filters([
                SelectFilter::make('specification')
                    ->label('Category')
                    ->options(function () {
                        return CounselorSessionLog::query()
                            ->select('specification')
                            ->distinct()
                            ->pluck('specification', 'specification')
                            ->toArray();
                    }),

                SelectFilter::make('counselor_id')
                    ->label('Counselor')
                    ->options(function () {
                        return User::query()
                            ->whereIn('role', ['counselor', 'admin'])
                            ->pluck('name', 'id')
                            ->toArray();
                    }),

                SelectFilter::make('date_range')
                    ->label('Period')
                    ->options([
                        'today' => 'Today',
                        'week' => 'This Week',
                        'month' => 'This Month',
                        'quarter' => 'This Quarter',
                    ])
                    ->query(function ($query, array $data) {
                        $value = $data['value'] ?? null;
                        if (!$value) return $query;

                        return match ($value) {
                            'today' => $query->whereDate('created_at', now()->toDateString()),
                            'week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                            'month' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                            'quarter' => $query->whereBetween('created_at', [now()->startOfQuarter(), now()->endOfQuarter()]),
                            default => $query,
                        };
                    }),
            ])

            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading(fn ($record) => "Session Log — {$record->client_name}"),
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])

            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCounselorSessionLogs::route('/'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->latest();
    }

    public static function getPluralLabel(): string
    {
        return 'Session Logs';
    }

    public static function getLabel(): string
    {
        return 'Session Log';
    }
}