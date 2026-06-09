<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StorybooksResource\Pages;
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
    protected static ?string $navigationGroup = 'Content Library';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('author')
                ->maxLength(255),

            Forms\Components\FileUpload::make('cover_image')
                ->image()
                ->directory('storybook-covers')
                ->maxSize(2048),

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
                    Forms\Components\FileUpload::make('illustration')
                        ->image()
                        ->directory('storybook-pages'),

                    Forms\Components\Textarea::make('page_text'),
                ])
                ->collapsible(),

            Forms\Components\Toggle::make('is_featured'),

            Forms\Components\Toggle::make('is_active')
                ->default(true),

            Forms\Components\Select::make('emotion_tags')
                ->multiple()
                ->relationship('emotions', 'mood'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('author')
                    ->sortable(),

                Tables\Columns\TextColumn::make('category'),
                    // ->formatStateUsing(function ($value) {
                    //     if (empty($value)) {
                    //         return 'N/A';
                    //     }

                    //     return ucwords(str_replace('_', ' ', $value));
                    // }),

                Tables\Columns\TextColumn::make('age_group'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
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
                    ]),

                Tables\Filters\SelectFilter::make('age_group')
                    ->options([
                        '4-7' => 'Ages 4-7',
                        '8-12' => 'Ages 8-12',
                        '13-17' => 'Ages 13-17',
                        '18+' => 'Adults',
                    ]),

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
            'index' => Pages\ListStorybooks::route('/'),
            'create' => Pages\CreateStorybooks::route('/create'),
            'edit' => Pages\EditStorybooks::route('/{record}/edit'),
        ];
    }
}