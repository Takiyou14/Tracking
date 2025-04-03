<?php

namespace App\Livewire;

use Livewire\Component;

class PackageTracking extends Component
{
    public $processedData = '';

    protected $listeners = ['tracking-processed' => 'updateProcessedData'];

    public function updateProcessedData($data)
    {
        $status = $data['status'];

        $this->processedData = $status;
    }

    public function render()
    {
        return view('livewire.package-tracking');
    }
}
