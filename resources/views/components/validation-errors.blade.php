@if ($errors->any() || session('error'))
    <div {{ $attributes->merge(['class' => 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900 dark:border-red-700 dark:text-red-100']) }}>
        <div class="font-semibold text-[12px]">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-2 list-disc list-inside text-[11px]">
            <!-- Display validation errors -->
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <!-- Display flashed error message -->
            @if (session('error'))
                <li>{{ session('error') }}</li>
            @endif
        </ul>
    </div>
@endif
