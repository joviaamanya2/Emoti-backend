<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmotionResource\Pages;
use App\Filament\Resources\EmotionResource\RelationManagers;
use App\Models\Emotion;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'create' => Pages\CreateEmotion::route('/create'),
            'edit' => Pages\EditEmotion::route('/{record}/edit'),
        ];
    }    
}
