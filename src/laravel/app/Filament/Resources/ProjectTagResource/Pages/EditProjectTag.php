<?php

namespace App\Filament\Resources\ProjectTagResource\Pages;

use App\Filament\Resources\ProjectTagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectTag extends EditRecord
{
    protected static string $resource = ProjectTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
