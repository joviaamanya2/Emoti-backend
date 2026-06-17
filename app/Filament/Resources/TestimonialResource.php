<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\UserTestimonial;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class TestimonialResource extends Resource
{
    protected static ?string $model = UserTestimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat';

    protected static ?string $navigationGroup = 'User Content';

    protected static ?string $navigationLabel = 'User Testimonials';

    // Disable creation completely
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->nullable(),

                Forms\Components\Toggle::make('is_approved')
                    ->label('Approved'),
                    
              
                Forms\Components\Toggle::make('display_on_ui')
                    ->label('Can be displayed on UI'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->default('Anonymous'),

                // Corrected: Using 'display_on_ui' and placed inside the array
                Tables\Columns\IconColumn::make('display_on_ui')
                    ->label('Can be displayed on UI')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean(),

                // Fixed to display specific date/time details and made sortable
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y g:i A') // Displays like: Jan 5, 2023 2:30 PM
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}