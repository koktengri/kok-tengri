<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMember extends EditRecord
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => auth()->user()?->hasRole('admin') ?? false),
        ];
    }

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()?->hasRole('admin'), 403);
        parent::authorizeAccess();
    }
}
