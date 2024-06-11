<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col items-center justify-center gap-5"
             @if ($pollingInterval = $this->getPollingInterval()) wire:poll.{{ $pollingInterval }} @endif
        >
            <div class="flex gap-3 w-full">
                <div class="relative flex-shrink-0">
                    <img src="{{ $avatar }}" alt="Avatar" class="w-16 h-16 rounded-full">
                </div>
                <div class="flex-1 ">
                    <div class="text-lg font-semibold">{{ $name }}</div>
                    <div class="text-sm text-gray-500">Level {{ $level }}</div>
                    <div class="mt-2">
                        <div class="flex w-full h-3.5 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700">
                            <div class="flex flex-col justify-center rounded-full overflow-hidden bg-yellow-400 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-yellow-600" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 w-full">
                <div class="grid grid-cols-2 gap-4">
                    @foreach($stats as $stat)
                        <div>
                            <div class="text-sm text-gray-500">{{ $stat['name'] }}</div>
                            <div class="flex w-full h-3.5 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700">
                                <div class="flex flex-col justify-center rounded-full overflow-hidden bg-lime-400 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-lime-600" style="width: {{ $stat['progress'] }}%; background-color: {{ $stat['color'] }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
