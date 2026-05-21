<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $navigationLabel = 'Users';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'counsellor'], true);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('contact')
                ->maxLength(20),

            Forms\Components\Select::make('role')
                ->options([
                    'user' => 'User',
                    'admin' => 'Admin',
                    'counsellor' => 'Counsellor',
                ])
                ->required(),

            Forms\Components\TextInput::make('password')
                ->password()
                ->required(fn (string $context) => $context === 'create') // Only required when creating
                ->nullable()
                ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                // FIXED: Changed fn ($state) to fn () because Fv2 doesn't pass $state here
                ->dehydrated(fn () => filled($this->getState())) 
                ->helperText('Leave blank to keep current password'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('contact')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('role')
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    // FIXED: Changed (string $state) to ($record) because Fv2 passes the Eloquent record to color()
                    ->color(fn ($record) => match ($record->role) {
                        'admin' => 'danger',
                        'counsellor' => 'warning',
                        'user' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                        'counsellor' => 'Counsellor',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->id !== auth()->id()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}