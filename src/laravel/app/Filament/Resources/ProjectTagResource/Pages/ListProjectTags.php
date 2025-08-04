<?php

namespace App\Filament\Resources\ProjectTagResource\Pages;

use App\Filament\Resources\ProjectTagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectTags extends ListRecords
{
    protected static string $resource = ProjectTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
