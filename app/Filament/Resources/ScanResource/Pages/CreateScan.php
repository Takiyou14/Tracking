<?php

namespace App\Filament\Resources\ScanResource\Pages;

use App\Filament\Resources\ScanResource;
use App\Models\Package;
use App\Models\Scan;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateScan extends CreateRecord
{
    protected static string $resource = ScanResource::class;

    public function mount(): void
    {
        parent::mount();
        $packageId = request()->get('id');
        if ($packageId) {
            $package = Package::findOrFail($packageId);
            $this->form->fill([
                'package_id' => $packageId,
            ]);
            $this->create();
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $roles = [
            'taker' => 'taken',
            'security' => 'security_checked',
            'loader' => 'loaded',
            'arriver' => 'arrived',
        ];
        $role = auth()->user()->role;
        $data['status'] = $roles[$role];

        $scan = Scan::where('package_id', $data['package_id'])
            ->where('status', $data['status']);

        if ($scan->exists()) {
            Notification::make()
                ->warning()
                ->title('This package has already been scanned.')
                ->persistent()
                ->send();

            $this->halt();
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
}
