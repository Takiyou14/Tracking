<?php

namespace App\Livewire;

use App\Models\Scan;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TrackPackage extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public bool $error = false;

    public function mount(): void
    {
        $this->form->fill();
        if (request()->has('data')) {
            $this->data['number'] = urldecode(request()->query('data'));
            $this->create();
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('number')
                    ->label(false)
                    ->placeholder('Tracking Number')
                    ->extraAttributes(
                        [
                            'style' => 'background:black; border-radius: 0; padding: 3px;border:2px solid white;height:2.5rem',
                        ]
                    ),

            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $trackingNumber = $this->data['number'];

        if (!empty($trackingNumber) || uuid_is_valid($trackingNumber)) {
            $scans = Scan::where('package_id', $trackingNumber)->get(['status', 'created_at'])->map(function ($scan) {
                return [
                    'status' => ucwords(str_replace('_', ' ', $scan->status)),
                    'time_ago' => $scan->created_at->diffForHumans(),
                ];
            });
            if ($scans->isNotEmpty()) {
                $this->dispatch('tracking-processed', $scans, $trackingNumber);
                $this->dispatch('update-url', url: "/?data=" . urlencode($trackingNumber));
                return;
            }
        }
        $this->error = true;
    }

    public function render(): View
    {
        return view('livewire.track-package');
    }
}
