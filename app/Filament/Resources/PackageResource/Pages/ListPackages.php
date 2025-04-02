<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPackages extends ListRecords
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Registered' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'registered')),
            'taken' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'taken')),
            'security_checked' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'security_checked')),
            'loaded' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'loaded')),
            'arrived' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'arrived')),
        ];
    }
}
