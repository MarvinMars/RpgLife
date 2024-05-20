@if($getState())
    <div class="flex w-full h-3.5 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700">
        <div class="flex flex-col justify-center rounded-full overflow-hidden bg-lime-400 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-lime-600" style="width: {{ $percent }}%"></div>
    </div>
@endif
