@if ($errors->any() || session('error'))
    <div {{ $attributes }}>
        <div class="font-medium text-red-600 dark:text-red-400">{{ __('Whoops! Something went wrong.') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600 dark:text-red-400">
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
