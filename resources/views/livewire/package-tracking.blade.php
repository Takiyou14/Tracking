<div>
    <p class="text-center font-mono text-amber-100">
        {{ $trackingNumber ?? 'Enter your tracking number' }}
    </p>
    <ol class="relative border-s-4 border-gray-200 w-max mx-auto">
        @foreach ($processedData as $data)
            <x-time :text="$data['status']" :time="$data['time_ago']" />
        @endforeach
    </ol>
</div>
