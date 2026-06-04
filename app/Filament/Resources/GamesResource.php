<?php

// app/Filament/Resources/GameResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\GamesResource\Pages;
use App\Models\Game;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class GamesResource extends Resource
{
    protected static ?string $model = Game::class;
    
    // Filament uses Heroicons/SVG registered by the Filament icon set.
    // The icon below must exist; otherwise panel boot fails.
    protected static ?string $navigationIcon = 'heroicon-o-bell';

    
    protected static ?string $navigationLabel = 'Games';
    
    protected static ?int $navigationSort = 30;
    
    protected static ?string $navigationGroup = 'Content Library';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\Select::make('type')
                    ->options([
                        'quiz' => 'Emotional Quiz',
                        'memory' => 'Memory Game',
                        'matching' => 'Emotion Matching',
                        'breathing' => 'Breathing Exercise',
                        'journaling' => 'Interactive Journaling',
                        'coloring' => 'Mandala Coloring',
                        'puzzle' => 'Puzzle',
                        'trivia' => 'Mental Health Trivia',
                    ])
                    ->required()
                    ->label('Game Type'),
                    
                Forms\Components\Select::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ])
                    ->default('easy'),
                    
                Forms\Components\Select::make('target_emotion')
                    ->options([
                        'happiness' => 'Happiness',
                        'calm' => 'Calm/Relaxation',
                        'confidence' => 'Confidence',
                        'anger_management' => 'Anger Management',
                        'anxiety_relief' => 'Anxiety Relief',
                        'self_awareness' => 'Self-Awareness',
                        'empathy' => 'Empathy',
                    ])
                    ->label('Target Emotion'),
                    
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                    
                Forms\Components\TextInput::make('game_url')
                    ->url()
                    ->label('Game URL/Link'),
                    
                Forms\Components\TextInput::make('estimated_duration')
                    ->numeric()
                    ->suffix('minutes'),
                    
                Forms\Components\Toggle::make('is_featured'),
                Forms\Components\Toggle::make('is_active')->default(true),
                
                Forms\Components\Select::make('age_group')
                    ->options([
                        'children' => 'Children (4-12)',
                        'teen' => 'Teens (13-17)',
                        'adult' => 'Adults (18+)',
                        'all' => 'All Ages',
                    ])
                    ->default('all'),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'success' => 'quiz',
                        'primary' => 'memory',
                        'warning' => 'matching',
                        'info' => 'breathing',
                        'purple' => 'journaling',
                        'pink' => 'coloring',
                        'gray' => 'puzzle',
                        'danger' => 'trivia',
                    ])
                    ->formatStateUsing(fn (string $state): string => 
                        str_replace('_', ' ', ucfirst($state))
                    ),
                    
                Tables\Columns\BadgeColumn::make('difficulty')
                    ->colors([
                        'success' => 'easy',
                        'warning' => 'medium',
                        'danger' => 'hard',
                    ]),
                    
                Tables\Columns\TextColumn::make('target_emotion')
                    ->formatStateUsing(fn (string $state): string => 
                        str_replace('_', ' ', ucfirst($state))
                    ),
                    
                Tables\Columns\TextColumn::make('estimated_duration')
                    ->suffix(' min')
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('age_group')
                    ->colors([
                        'pink' => 'children',
                        'purple' => 'teen',
                        'blue' => 'adult',
                        'gray' => 'all',
                    ]),
                    
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type'),
                Tables\Filters\SelectFilter::make('difficulty'),
                Tables\Filters\SelectFilter::make('target_emotion'),
                Tables\Filters\SelectFilter::make('age_group'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGames::route('/create'),
            'edit' => Pages\EditGames::route('/{record}/edit'),
        ];
    }
}