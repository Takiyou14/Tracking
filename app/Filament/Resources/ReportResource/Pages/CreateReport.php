<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use App\Models\Package;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;
    public ?string $packageId;

    public function mount(): void
    {
        parent::mount();
        $this->packageId = request()->get('id');
        $package = Package::findOrFail($this->packageId);
        if ($package->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['package_id'] = $this->packageId;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
