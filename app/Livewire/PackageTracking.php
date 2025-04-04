<?php

namespace App\Livewire;

use Livewire\Component;

class PackageTracking extends Component
{
    public array $processedData = [];
    public string $trackingNumber;

    protected $listeners = ['tracking-processed' => 'updateProcessedData'];

    public function updateProcessedData($data, $track)
    {
        $this->trackingNumber = $track;
        $this->processedData = $data;
    }

    public function render()
    {
        return view('livewire.package-tracking');
    }
}
