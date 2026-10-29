<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\Tag;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Gönderiler';

    protected static ?string $modelLabel = 'gönderi';

    protected static ?string $pluralModelLabel = 'gönderiler';

    protected static string|\UnitEnum|null $navigationGroup = 'İçerik Yönetimi';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')
                ->label('Yazar')
                ->relationship('author', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Select::make('category_id')
                ->label('Kategori')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
            TextInput::make('title')
                ->label('Başlık')
                ->required()
                ->maxLength(180)
                ->live(onBlur: true)
                ->afterStateUpdated(function (?string $state, callable $set, string $operation): void {
                    if ($operation === 'create' && filled($state)) {
                        $set('slug', Str::slug($state));
                    }
                }),
            TextInput::make('slug')
                ->label('URL kısa adı')
                ->required()
                ->maxLength(220)
                ->unique(ignoreRecord: true),
            Textarea::make('excerpt')
                ->label('Kısa açıklama')
                ->maxLength(500)
                ->rows(3)
                ->columnSpanFull(),
            RichEditor::make('body')
                ->label('İçerik')
                ->required()
                ->columnSpanFull(),
            Select::make('tags')
                ->label('Etiketler')
                ->multiple()
                ->relationship('tags', 'name')
                ->searchable()
                ->preload()
                ->columnSpanFull(),
            Select::make('status')
                ->label('Durum')
                ->options([
                    'draft' => 'Taslak',
                    'published' => 'Yayımlandı',
                    'hidden' => 'Gizli',
                ])
                ->default('published')
                ->required(),
            DateTimePicker::make('published_at')
                ->label('Yayın tarihi')
                ->seconds(false),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('title')->label('Başlık')->searchable()->sortable()->limit(55),
                TextColumn::make('author.name')->label('Yazar')->searchable()->sortable(),
                TextColumn::make('category.name')->label('Kategori')->placeholder('—'),
                TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => [
                        'published' => 'Yayımlandı',
                        'draft' => 'Taslak',
                        'hidden' => 'Gizli',
                    ][$state] ?? $state),
                TextColumn::make('views_count')->label('Görüntülenme')->numeric()->sortable(),
                TextColumn::make('published_at')->label('Yayın tarihi')->dateTime('d.m.Y H:i')->sortable()->placeholder('—'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
