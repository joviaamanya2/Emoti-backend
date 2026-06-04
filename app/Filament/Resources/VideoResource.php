<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationLabel = 'Videos';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationGroup = 'Content Library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('video_url')
                    ->url()
                    ->required()
                    ->label('Video URL'),

                Forms\Components\Select::make('category')
                    ->options([
                        'fitness' => 'Fitness',
                        'meditation' => 'Meditation',
                        'yoga' => 'Yoga',
                        'mindfulness' => 'Mindfulness',
                        'motivation' => 'Motivation',
                        'breathing' => 'Breathing Exercises',
                        'self_care' => 'Self Care',
                    ])
                    ->required()
                    ->label('Category'),

                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('duration')
                    ->numeric()
                    ->suffix('minutes'),

                Forms\Components\Toggle::make('is_featured')
                    ->label('Featured Video'),

                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->label('Active'),

                Forms\Components\Select::make('emotion_tags')
                    ->multiple()
                    ->relationship('emotions', 'name')
                    ->label('Related Emotions'),

                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->directory('video-thumbnails')
                    ->label('Thumbnail'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('category')
                    ->colors([
                        'success' => 'fitness',
                        'primary' => 'meditation',
                        'warning' => 'yoga',
                        'info' => 'mindfulness',
                        'danger' => 'motivation',
                        'secondary' => 'breathing',
                    ])
                    ->formatStateUsing(function ($state) {
                        return str_replace('_', ' ', ucfirst($state));
                    }),

                Tables\Columns\TextColumn::make('duration')
                    ->suffix(' min')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'fitness' => 'Fitness',
                        'meditation' => 'Meditation',
                        'yoga' => 'Yoga',
                        'mindfulness' => 'Mindfulness',
                        'motivation' => 'Motivation',
                        'breathing' => 'Breathing Exercises',
                        'self_care' => 'Self Care',
                    ]),

                Tables\Filters\TernaryFilter::make('is_featured'),

                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}