<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center font-['Inter']">
<div class="max-w-md mx-4 p-8 bg-white rounded-xl shadow-lg text-center">
    <div class="flex justify-center mb-6">
        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-4">Maintenance in Progress</h1>

    <p class="text-gray-600 mb-6">
        {{ $message ?? "We're performing scheduled maintenance to improve your experience. Please check back shortly." }}
    </p>

    @isset($retryAfter)
        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <p class="text-gray-700 mb-2">We'll automatically refresh the page in:</p>
            <div class="text-4xl font-bold text-indigo-600" id="countdown">{{ $retryAfter }}</div>
            <p class="text-sm text-gray-500 mt-1">seconds</p>
        </div>
    @endisset

    <div class="text-sm text-gray-500">
        <p>Thank you for your patience.</p>
        <p class="mt-1">Our team is working hard to get things back to normal.</p>
    </div>
</div>

@isset($retryAfter)
    <script>
        let time = {{ $retryAfter }};
        const countdownElement = document.getElementById('countdown');

        const interval = setInterval(() => {
            time--;
            countdownElement.textContent = time;

            if (time <= 0) {
                clearInterval(interval);
                window.location.reload();
            }
        }, 1000);
    </script>
@endisset
</body>
</html>
