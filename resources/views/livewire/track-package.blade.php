<div>
    <form wire:submit="create" class="flex items-start">
        {{ $this->form }}

        <x-filament::button type="submit" style="border-radius: 0;"
            class="cursor-pointer h-10 text-[10px] font-semibold tracking-wide border-2 border-l-0 border-white">
            Start Tracking
        </x-filament::button>

    </form>

    @if ($this->error === true)
        <li class="text-red-500 m-2 ml-7 text-[10px] list-disc">
            Please enter a valid Number.
        </li>
    @endif

    <x-filament-actions::modals />
</div>
