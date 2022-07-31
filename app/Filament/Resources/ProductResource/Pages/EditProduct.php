<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function beforeFill()
    {
        $this->record->price = round($this->record->price / 100, 2);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['price'] = intval($data['price'] * 100);

        return $data;
    }
}
