<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SessionResource\Pages;
use App\Models\Session;
use App\Models\User;
use App\Models\Counselor;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class SessionResource extends Resource
{
    protected static ?string $model = Session::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Counseling Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Session Allocation')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Allocate to Patient (User)')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('counselor_id')
                            ->label('Assign Counselor')
                            ->options(Counselor::where('status', 1)->pluck('name', 'id')) // 1 means active
                            ->searchable()
                            ->required(),

                        Forms\Components\DateTimePicker::make('scheduled_at')
                            ->required()
                            ->columnSpan(2)
                            ->label('Date & Time'),
                    ]),

                Forms\Components\Section::make('Session Management & Proof')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->required()
                            ->options([
                                'scheduled' => 'Scheduled (Pending)',
                                'ongoing' => 'Ongoing (In Progress)',
                                'completed' => 'Completed (Done)',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('scheduled'),

                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Internal Admin Notes (Not visible to user)')
                            ->rows(3)
                            ->columnSpan(2),

                        Forms\Components\FileUpload::make('session_screenshot')
                            ->label('Upload Session Proof/Screenshot (Upload after marking as Done)')
                            ->image()
                            ->directory('session-screenshots')
                            ->columnSpan(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->dateTime('M d, Y | h:i A')
                    ->sortable()
                    ->label('Scheduled Time'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Patient')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('counselor.name')
                    ->label('Counselor')
                    ->searchable()
                    ->sortable(),

                // FIXED TYPO HERE: Changed ->label([ to ->colors([
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

                // Hide screenshot column by default to keep table clean, admins can toggle it
                ImageColumn::make('session_screenshot')
                    ->label('Proof')
                    ->circular()
                    ->toggleable(isToggledHiddenByDefault: true), 
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
                    ->options(Counselor::all()->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Manage Session'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('scheduled_at', 'desc'); // Show newest sessions first
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
            'index' => Pages\ListSessions::route('/'),
            'create' => Pages\CreateSessions::route('/create'),
            'edit' => Pages\EditSessions::route('/{record}/edit'),
        ];
    }
}