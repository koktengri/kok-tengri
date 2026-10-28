<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kategoriler';

    protected static ?string $modelLabel = 'kategori';

    protected static ?string $pluralModelLabel = 'kategoriler';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Kategori adı')
                ->required()
                ->maxLength(150)
                ->live(onBlur: true)
                ->afterStateUpdated(function (?string $state, callable $set, string $operation): void {
                    if ($operation === 'create' && filled($state)) {
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    }
                }),

            TextInput::make('slug')
                ->label('URL kısa adı')
                ->required()
                ->maxLength(180)
                ->unique(ignoreRecord: true)
                ->helperText('URL içinde kullanılacak benzersiz kısa ad.'),

            Textarea::make('description')
                ->label('Açıklama')
                ->rows(3)
                ->columnSpanFull(),

            Select::make('parent_id')
                ->label('Üst kategori')
                ->relationship('parent', 'name')
                ->searchable()
                ->preload()
                ->nullable(),

            TextInput::make('sort_order')
                ->label('Sıralama')
                ->numeric()
                ->default(0)
                ->minValue(0)
                ->required(),

            Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Kısa ad')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('parent.name')
                    ->label('Üst kategori')
                    ->placeholder('—'),

                IconColumn::make('is_active')
                    ->label('Durum')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Güncellendi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
