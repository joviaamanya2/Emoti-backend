<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentsResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Resources\Table as ResourceTable;
use Filament\Tables;


class AppointmentsResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Counseling';

    // In v2, we just don't define a form() method if we don't want it, 
    // but we keep canCreate() false just in case.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(ResourceTable $table): ResourceTable

    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('appointment_time')
                    ->dateTime()
                    ->sortable()
                    ->label('Date & Time'),

                // Shows Online or Physical
                Tables\Columns\BadgeColumn::make('location_type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'online',
                        'success' => 'physical',
                    ])
                    ->formatStateUsing(fn ($state) => $state ? ucfirst($state) : 'N/A'),

                Tables\Columns\TextColumn::make('location')
                    ->label('Location Details')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved', // Updated to 'approved'
                        'danger' => 'cancelled',
                        'primary' => 'completed',
                    ])
                    ->formatStateUsing(fn ($state) => ucfirst($state)),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ]),
                    
                Tables\Filters\SelectFilter::make('location_type')
                    ->label('Appointment Type')
                    ->options([
                        'online' => 'Online',
                        'physical' => 'Physical',
                    ]),
            ])
            ->actions([
                // Dropdown action to change status
                Tables\Actions\Action::make('change_status')
                    ->label('Change Status')
                    ->icon('heroicon-o-arrow-path')
                    ->modalHeading('Update Appointment Status')
                    ->modalButton('Update')
                    ->form([
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'cancelled' => 'Cancelled',
                                'completed' => 'Completed',
                            ])
                            ->required()
                            ->default(fn ($record) => $record->status),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update(['status' => $data['status']]);
                    })
                    ->visible(fn ($record) => !in_array($record->status, ['completed', 'cancelled'])),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('approve')
                    ->label('Approve Selected')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn ($records) => $records->each->update(['status' => 'approved']))
                    ->requiresConfirmation(),
                    

                    
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            // Removed the 'create' route to remove the button
            'index' => Pages\ListAppointments::route('/'),
            // Kept edit in case you want a dedicated page later, can be removed if unused
            'edit' => Pages\EditAppointment::route('/{record}/edit'), 
        ];
    }
}