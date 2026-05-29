<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CounselorAssignmentResource\Pages;
use App\Models\CounselorAssignment;
use App\Models\Counselor;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class CounselorAssignmentResource extends Resource
{
    protected static ?string $model = CounselorAssignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Counseling Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Assignment Details')
                    ->description('Select the patient and the counselor for this session.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Patient / User')
                                    ->options(User::query()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->preload()
                                    ->columnSpan(1),

                                Select::make('counselor_id')
                                    ->label('Counselor')
                                    ->options(Counselor::query()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->preload()
                                    ->columnSpan(1),
                            ]),
                    ])->columnSpanFull(),

                Section::make('Schedule & Logistics')
                    ->description('Set the time and how the session will be conducted.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('scheduled_at')
                                    ->label('Scheduled Time')
                                    ->required()
                                    ->minutesStep(15)
                                    ->columnSpan(1),

                                Select::make('session_type')
                                    ->label('Session Medium')
                                    ->options([
                                        'online' => 'Online (Video/Audio Call)',
                                        'physical' => 'Physical (In-Person)',
                                    ])
                                    ->required()
                                    ->default('online')
                                    ->columnSpan(1),
                            ]),
                    ])->columnSpanFull(),

                Section::make('Appointment Status')
                    ->description('Accept or reject this assignment. Only accepted assignments are visible to patients.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'pending' => '⏳ Pending Review',
                                        'accepted' => '✅ Accepted',
                                        'rejected' => '❌ Rejected',
                                        'completed' => '🏁 Completed',
                                        'cancelled' => '🚫 Cancelled',
                                    ])
                                    ->required()
                                    ->default('pending')
                                    ->columnSpan(1)
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                        if ($state === 'rejected') {
                                            $set('rejection_reason', $get('rejection_reason') ?? '');
                                        } else {
                                            $set('rejection_reason', null);
                                        }
                                    }),

                                Textarea::make('rejection_reason')
                                    ->label('Rejection Reason')
                                    ->placeholder('Explain why this assignment was rejected (visible to admin only)...')
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->columnSpan(1)
                                    ->visible(fn (callable $get) => $get('status') === 'rejected')
                                    ->required(fn (callable $get) => $get('status') === 'rejected'),
                            ]),
                    ])->columnSpanFull(),

                Section::make('Administration')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Internal Admin Notes')
                            ->placeholder('e.g., Patient requested specifically for this counselor, special accommodations needed, follow-up required after 2 weeks, patient has history of anxiety with new counselors so assigned their previous therapist, insurance verification pending, family member confirmed availability for physical sessions on weekdays between 10 AM and 2 PM...')
                            ->maxLength(2000)
                            ->rows(6)
                            ->columnSpanFull()
                            ->helperText('Internal notes only — not visible to patients or counselors. Use this to document context, special instructions, or coordination details.'),
                    ])->columnSpanFull(),

                Section::make('Record Info')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Created')
                                    ->content(fn ($record) => $record?->created_at?->format('M d, Y h:i A') ?? '—')
                                    ->columnSpan(1),

                                Placeholder::make('updated_at')
                                    ->label('Last Updated')
                                    ->content(fn ($record) => $record?->updated_at?->diffForHumans() ?? '—')
                                    ->columnSpan(1),

                                Placeholder::make('status_updated_at')
                                    ->label('Status Changed')
                                    ->content(fn ($record) => $record?->status_updated_at?->diffForHumans() ?? '—')
                                    ->columnSpan(1),
                            ]),
                    ])->columnSpanFull()
                    ->collapsed()
                    ->hidden(fn ($livewire) => $livewire instanceof Pages\CreateCounselorAssignment),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Patient')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): string => $record->user?->email ?? ''),

                TextColumn::make('counselor.name')
                    ->label('Counselor')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record): string => $record->counselor?->specialty ?? ''),

                TextColumn::make('scheduled_at')
                    ->label('Scheduled Time')
                    ->dateTime('M d, Y | h:i A')
                    ->sortable()
                    ->since()
                    ->description(fn ($record): string => $record->scheduled_at->format('h:i A')),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                        'primary' => 'completed',
                        'gray' => 'cancelled',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'accepted',
                        'heroicon-o-x-circle' => 'rejected',
                        'heroicon-o-flag' => 'completed',
                        'heroicon-o-ban' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        default => $state,
                    })
                    ->tooltip(fn ($record): string => match($record->status) {
                        'rejected' => $record->rejection_reason ?? 'No reason provided',
                        default => $record->status,
                    }),

                BadgeColumn::make('session_type')
                    ->label('Medium')
                    ->colors([
                        'primary' => 'online',
                        'success' => 'physical',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'online' => 'Online',
                        'physical' => 'Physical',
                        default => $state,
                    }),

                TextColumn::make('notes')
                    ->label('Admin Notes')
                    ->limit(40)
                    ->tooltip(fn ($record): string => $record->notes ?? 'No notes')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Assigned On')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending'),

                SelectFilter::make('session_type')
                    ->label('Medium')
                    ->options([
                        'online' => 'Online',
                        'physical' => 'Physical',
                    ]),

                SelectFilter::make('counselor_id')
                    ->label('Counselor')
                    ->options(Counselor::query()->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\Action::make('accept')
                    ->label('Accept')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update([
                        'status' => 'accepted',
                        'status_updated_at' => now(),
                    ])),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Reason for rejection')
                            ->required()
                            ->maxLength(500)
                            ->rows(3)
                            ->placeholder('Provide a reason for rejecting this assignment...'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'rejection_reason' => $data['rejection_reason'],
                            'status_updated_at' => now(),
                        ]);
                    }),

                Tables\Actions\Action::make('complete')
                    ->label('Complete')
                    ->icon('heroicon-o-flag')
                    ->color('primary')
                    ->visible(fn ($record) => $record->status === 'accepted')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update([
                        'status' => 'completed',
                        'status_updated_at' => now(),
                    ])),

                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => in_array($record->status, ['pending', 'accepted'])),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => in_array($record->status, ['pending', 'rejected', 'cancelled'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('accept_selected')
                    ->label('Accept Selected')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function ($records) {
                        $records->each(fn ($record) => $record->update([
                            'status' => 'accepted',
                            'status_updated_at' => now(),
                        ]));
                    }),
                    

                Tables\Actions\BulkAction::make('reject_selected')
                    ->label('Reject Selected')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Textarea::make('bulk_rejection_reason')
                            ->label('Reason for rejection (applies to all)')
                            ->required()
                            ->maxLength(500)
                            ->rows(3),
                    ])
                    ->action(function ($records, array $data) {
                        $records->each(fn ($record) => $record->update([
                            'status' => 'rejected',
                            'rejection_reason' => $data['bulk_rejection_reason'],
                            'status_updated_at' => now(),
                        ]));
                    }),
                    

                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => false),
            ])
            ->defaultSort('scheduled_at', 'desc');
            
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
            'index' => Pages\ListCounselorAssignments::route('/'),
            'create' => Pages\CreateCounselorAssignment::route('/create'),
            'edit' => Pages\EditCounselorAssignment::route('/{record}/edit'),
        ];
    }
}