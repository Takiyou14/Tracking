<div>
    <p class="text-center text-amber-100">
        {{ $trackingNumber ?? 'Enter your tracking number' }}
    </p>
    <ol class="relative border-s-4 border-gray-200 w-max mx-auto">
        @foreach ($processedData as $data)
            <x-time :text="$data['status']" :time="$data['time_ago']" />
        @endforeach
    </ol>
    @if ($trackingNumber)
        <p class="text-center text-amber-100 text-xs underline">
            <a href="{{ route('filament.dashboard.resources.reports.create', ['id' => $trackingNumber]) }}">
                Report an issue
            </a>
        </p>
    @endif

</div>
