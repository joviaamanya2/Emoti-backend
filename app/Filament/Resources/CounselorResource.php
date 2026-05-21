<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CounselorResource\Pages;
use App\Models\Counselor;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class CounselorResource extends Resource
{
    protected static ?string $model = Counselor::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Counseling Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('profile_photo')
                            ->image()
                            ->avatar()
                            ->directory('counselor-avatars')
                            ->imageResizeTargetWidth('150')
                            ->imageResizeTargetHeight('150'),

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),
                    ]),

                Forms\Components\Section::make('Professional Details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('specification')
                            ->required()
                            ->label('Specialization')
                            ->options([
                                'cbt' => 'Cognitive Behavioral Therapy (CBT)',
                                'trauma' => 'Trauma & PTSD',
                                'anxiety' => 'Anxiety Disorders',
                                'depression' => 'Depression',
                                'grief' => 'Grief & Loss',
                                'relationship' => 'Relationship & Marriage',
                                'family' => 'Family Therapy',
                                'substance' => 'Substance Abuse & Addiction',
                                'eating' => 'Eating Disorders',
                                'adhd' => 'ADHD & Executive Functioning',
                                'ocd' => 'OCD & Related Disorders',
                                'bipolar' => 'Bipolar Disorder',
                                'stress' => 'Stress Management',
                                'self_esteem' => 'Self-Esteem & Identity',
                                'anger' => 'Anger Management',
                                'career' => 'Career Counseling',
                                'child' => 'Child & Adolescent',
                                'geriatric' => 'Geriatric Counseling',
                                'lgbtq' => 'LGBTQ+ Affirmative Therapy',
                                'mindfulness' => 'Mindfulness & Meditation',
                            ])
                            ->searchable()
                            ->placeholder('Select a specialization'),

                        Forms\Components\TextInput::make('specialty')
                            ->label('General Specialty (e.g., Clinical Psychologist)')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('address')
                            ->rows(2)
                            ->columnSpan(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // BadgeColumn will automatically display the full dropdown label (e.g., "Stress Management")
                BadgeColumn::make('specification')
                    ->label('Specialization')
                    ->color(function ($state) {
                        return match ($state) {
                            'cbt' => 'primary',
                            'trauma' => 'danger',
                            'anxiety' => 'warning',
                            'depression' => 'gray',
                            'grief' => 'secondary',
                            'relationship' => 'pink',
                            'family' => 'success',
                            'substance' => 'red',
                            'eating' => 'purple',
                            'adhd' => 'orange',
                            'ocd' => 'indigo',
                            'bipolar' => 'fuchsia',
                            'stress' => 'cyan',
                            'self_esteem' => 'emerald',
                            'anger' => 'rose',
                            'career' => 'blue',
                            'child' => 'teal',
                            'geriatric' => 'slate',
                            'lgbtq' => 'violet',
                            'mindfulness' => 'lime',
                            default => 'gray',
                        };
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),

                // Added address to the table, limited to 50 chars to keep the table tidy
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->address; // Shows full address on hover
                    }),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                SelectFilter::make('specification')
                    ->label('Specialization')
                    ->options([
                        'cbt' => 'Cognitive Behavioral Therapy (CBT)',
                        'trauma' => 'Trauma & PTSD',
                        'anxiety' => 'Anxiety Disorders',
                        'depression' => 'Depression',
                        'grief' => 'Grief & Loss',
                        'relationship' => 'Relationship & Marriage',
                        'family' => 'Family Therapy',
                        'substance' => 'Substance Abuse & Addiction',
                        'eating' => 'Eating Disorders',
                        'adhd' => 'ADHD & Executive Functioning',
                        'ocd' => 'OCD & Related Disorders',
                        'bipolar' => 'Bipolar Disorder',
                        'stress' => 'Stress Management',
                        'self_esteem' => 'Self-Esteem & Identity',
                        'anger' => 'Anger Management',
                        'career' => 'Career Counseling',
                        'child' => 'Child & Adolescent',
                        'geriatric' => 'Geriatric Counseling',
                        'lgbtq' => 'LGBTQ+ Affirmative Therapy',
                        'mindfulness' => 'Mindfulness & Meditation',
                    ]),
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
            'index' => Pages\ListCounselors::route('/'),
            'create' => Pages\CreateCounselor::route('/create'),
            'edit' => Pages\EditCounselor::route('/{record}/edit'),
        ];
    }
}