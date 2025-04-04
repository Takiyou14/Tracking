<li class="my-6 ms-6">
    <span class="absolute flex items-center justify-center w-7 h-7 rounded-full -start-4 bg-white">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-amber-800">
            <path fill-rule="evenodd"
                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                clip-rule="evenodd" />
        </svg>
    </span>
    <h3 class="flex items-center mb-1 text-lg">
        <span class="bg-amber-100 text-amber-800 text-sm font-semibold me-2 px-2.5 py-0.5 rounded-sm ms-3">
            {{ $text }}
        </span>
    </h3>
    <time class="block ml-5 mb-2 text-xs font-normal leading-none text-gray-400">
        {{ $time }}
    </time>
</li>
