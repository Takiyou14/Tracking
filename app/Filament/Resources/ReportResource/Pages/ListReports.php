<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Open' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'open')),
            'Progress' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'in_progress')),
            'Resloved' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'resolved')),
        ];
    }
}
