<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmotionResource\Pages;
use App\Filament\Resources\EmotionResource\RelationManagers;
use App\Models\Emotion;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmotionResource extends Resource
{
    protected static ?string $model = Emotion::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    // protected static ?string $navigationIcon = 'heroicon-o-face-smile';
    protected static ?string $navigationGroup = 'Emoti Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('mood')
                    ->required()
                    ->label('Mood'),

                TextInput::make('emoji')
                    ->label('Emoji'),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('mood')->label('Mood')->searchable()->sortable(),
                TextColumn::make('emoji')->label('Emoji'),
                TextColumn::make('description')->label('Description')->limit(50),
                TextColumn::make('created_at')->label('Created')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
            'index' => Pages\ListEmotions::route('/'),
            'edit' => Pages\EditEmotion::route('/{record}/edit'),
        ];
    }    
}
