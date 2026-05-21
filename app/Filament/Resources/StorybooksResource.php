<?php

// app/Filament/Resources/StorybookResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryBooksResource\Pages;

use App\Models\Storybook;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class StorybooksResource extends Resource
{
    protected static ?string $model = Storybook::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    
    protected static ?string $navigationLabel = 'Storybooks';
    
    protected static ?int $navigationSort = 20;
    
    protected static ?string $navigationGroup = 'CONTENT LIBRARY';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('author')
                    ->maxLength(255),
                    
                Forms\Components\Select::make('category')
                    ->options([
                        'emotional_wellness' => 'Emotional Wellness',
                        'self_esteem' => 'Self-Esteem',
                        'anxiety' => 'Anxiety Management',
                        'anger' => 'Anger Management',
                        'grief' => 'Grief & Loss',
                        'mindfulness' => 'Mindfulness',
                        'children' => 'Children Stories',
                        'teen' => 'Teen Stories',
                        'adult' => 'Adult Stories',
                    ])
                    ->required(),
                    
                Forms\Components\Select::make('age_group')
                    ->options([
                        '4-7' => 'Ages 4-7',
                        '8-12' => 'Ages 8-12',
                        '13-17' => 'Ages 13-17',
                        '18+' => 'Adults',
                    ]),
                    
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                    
                Forms\Components\Repeater::make('pages')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('illustration')
                            ->image()
                            ->collection('storybook-pages'),
                        Forms\Components\Textarea::make('page_text'),
                    ])
                    ->collapsible(),
                    
                Forms\Components\Toggle::make('is_featured'),
                Forms\Components\Toggle::make('is_active')->default(true),
                    
                Forms\Components\Select::make('emotion_tags')
                    ->multiple()
                    ->relationship('emotions', 'name'),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover_image')
                    ->collection('storybook-covers')
                    ->circular(),
                    
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('author')
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('category')
                    ->formatStateUsing(fn (string $state): string => 
                        str_replace('_', ' ', ucfirst($state))
                    ),
                    
                Tables\Columns\BadgeColumn::make('age_group')
                    ->colors([
                        'pink' => '4-7',
                        'purple' => '8-12',
                        'indigo' => '13-17',
                        'blue' => '18+',
                    ]),
                    
                Tables\Columns\IconColumn::make('is_featured')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category'),
                Tables\Filters\SelectFilter::make('age_group'),
                Tables\Filters\TernaryFilter::make('is_featured'),
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
            // These page class names must match the actual Pages namespace.
            // If your Pages don't exist, Filament will throw a fatal error during boot.
'index' => Pages\ListStoryBooks::route('/'),
            'create' => Pages\CreateStoryBooks::route('/create'),
            'edit' => Pages\EditStoryBooks::route('/{record}/edit'),
        ];
    }
}