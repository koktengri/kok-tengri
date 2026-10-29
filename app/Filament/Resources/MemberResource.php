<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Üyeler';

    protected static ?string $modelLabel = 'üye';

    protected static ?string $pluralModelLabel = 'üyeler';

    protected static string|\UnitEnum|null $navigationGroup = 'Topluluk Yönetimi';

    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('role')
                ->label('Üye rolü')
                ->options([
                    'member' => 'Üye',
                    'author' => 'Yazar',
                    'editor' => 'Editör',
                    'admin' => 'Yönetici',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')->label('Ad soyad')->searchable()->sortable(),
                TextColumn::make('email')->label('E-posta')->searchable()->copyable(),
                TextColumn::make('role')
                    ->label('Rol')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'editor' => 'warning',
                        'author' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => [
                        'member' => 'Üye',
                        'author' => 'Yazar',
                        'editor' => 'Editör',
                        'admin' => 'Yönetici',
                    ][$state] ?? $state),
                TextColumn::make('posts_count')->label('Gönderiler')->counts('posts')->sortable(),
                TextColumn::make('created_at')->label('Kayıt tarihi')->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
