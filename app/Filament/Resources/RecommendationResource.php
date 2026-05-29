<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecommendationResource\Pages;
use App\Models\Recommendation;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Table;

class RecommendationResource extends Resource
{
    protected static ?string $model = Recommendation::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Emoti Management';
    protected static ?int $navigationSort = 2; // Orders it in the sidebar

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Recommendation Details')
                    ->tabs([
                        // TAB 1: General Info
                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\Select::make('mood_id')
                                    ->relationship('emotion', 'mood') // Assumes you have an Emotion model with a 'name' field
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('Emotion'),
                                
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'video' => 'Video',
                                        'music' => 'Music',
                                        'text' => 'Text / Tips Only',
                                        'combined' => 'Combined (Video/Music + Text)',
                                    ])
                                    ->required(),
                                    

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active (Visible to users)')
                                    ->default(true),
                            ])->columns(2),

                        // TAB 2: Media Uploads
                        Forms\Components\Tabs\Tab::make('Media')
                            ->schema([
                                Forms\Components\FileUpload::make('video_path')
                                    ->label('Video File')
                                    ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                                    ->maxSize(102400) // 100MB
                                    ->disk('s3') // Change to 'public' if not using S3
                                    ->directory('recommendation-videos')
                                    ->columnSpanFull(),
                                    
                                Forms\Components\FileUpload::make('music_path')
                                    ->label('Music / Audio File')
                                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/ogg'])
                                    ->maxSize(51200) // 50MB
                                    ->disk('s3') // Change to 'public' if not using S3
                                    ->directory('recommendation-music')
                                    ->columnSpanFull(),
                            ]),
                            
                        // TAB 3: Tips & Text
                        Forms\Components\Tabs\Tab::make('Tips & Text')
                            ->schema([
                                Forms\Components\RichEditor::make('tips_text')
                                    ->label('Recommendation Tips')
                                    ->placeholder('Enter helpful tips, breathing exercises, or advice for this emotion...')
                                    ->toolbarButtons([
                                        'attachFiles',
                                        'bold',
                                        'bulletList',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'strike',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mood.name')
                    ->label('Mood')
                    ->sortable()
                    ->searchable()
                    ->color('primary'),
                    
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    }),
                    
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'danger' => 'video',
                        'success' => 'music',
                        'warning' => 'text',
                        'info' => 'combined',
                    ]),
                    
                Tables\Columns\IconColumn::make('video_path')
                    ->label('Has Video')
                    ->boolean()
                    ->trueIcon('heroicon-o-video-camera')
                    ->falseIcon('heroicon-o-x-mark'),
                    
                Tables\Columns\IconColumn::make('music_path')
                    ->label('Has Audio')
                    ->boolean()
                    ->trueIcon('heroicon-o-musical-note')
                    ->falseIcon('heroicon-o-x-mark'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('emotion')
                    ->relationship('mood', 'mood'),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'video' => 'Video',
                        'music' => 'Music',
                        'text' => 'Text / Tips Only',
                        'combined' => 'Combined',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make()
                    ->beforeReplicaSaved(function (Recommendation $replica, Recommendation $original): void {
                        $replica->title = $original->title . ' (Copy)';
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListRecommendations::route('/'),
            'create' => Pages\CreateRecommendation::route('/create'),
            'edit' => Pages\EditRecommendation::route('/{record}/edit'),
        ];
    }    
}