<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-hashtag';

    protected static ?string $navigationLabel = 'Etiketler';

    protected static ?string $modelLabel = 'etiket';

    protected static ?string $pluralModelLabel = 'etiketler';

    protected static string|\UnitEnum|null $navigationGroup = 'İçerik Yönetimi';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Etiket adı')
                ->required()
                ->maxLength(100)
                ->live(onBlur: true)
                ->afterStateUpdated(function (?string $state, callable $set, string $operation): void {
                    if ($operation === 'create' && filled($state)) {
                        $set('slug', Str::slug($state));
                    }
                }),
            TextInput::make('slug')
                ->label('URL kısa adı')
                ->required()
                ->maxLength(120)
                ->unique(ignoreRecord: true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                TextColumn::make('name')->label('Etiket')->searchable()->sortable(),
                TextColumn::make('slug')->label('Kısa ad')->searchable()->copyable(),
                TextColumn::make('posts_count')->label('Gönderi sayısı')->counts('posts')->sortable(),
                TextColumn::make('created_at')->label('Oluşturuldu')->dateTime('d.m.Y H:i')->sortable(),
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
