<html>
<head>
    <title>
        Login
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 25%, #c3cfe2 100%);
            overflow: hidden;
        }
        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        .background-animation div {
            position: absolute;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: move 10s infinite;
        }
        @keyframes move {
            0% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-100vh) translateX(100vw);
            }
            100% {
                transform: translateY(0) translateX(0);
            }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
<div class="background-animation">
    <div style="top: 10%; left: 20%; animation-delay: 0s;"></div>
    <div style="top: 30%; left: 40%; animation-delay: 2s;"></div>
    <div style="top: 50%; left: 60%; animation-delay: 4s;"></div>
    <div style="top: 70%; left: 80%; animation-delay: 6s;"></div>
    <div style="top: 90%; left: 10%; animation-delay: 8s;"></div>
</div>
<div class="w-full max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg h-full sm:h-auto">
    <div class="text-center mb-6">
        <img alt="Logo" class="mx-auto mb-4" height="50" src="https://storage.googleapis.com/a1aa/image/Zyua2fuc_YxTb8eLE0cKyZiVTUf5NPS90ABNsXx7T7A.jpg" width="150"/>
        <h1 class="text-2xl font-bold text-black" style="font-size: 12px;">
            Login
        </h1>
        <p class="text-gray-800" style="font-size: 11px;">
            Hi, Welcome back 👋
        </p>
        <p class="text-gray-800" style="font-size: 11px;">
            Please login to provide your feedback.
        </p>
    </div>
    <form>
        <div class="mb-4">
            <label class="block text-gray-800" for="username" style="font-size: 11px;">
                Username
            </label>
            <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" id="username" placeholder="e.g. johndoe@gmail.com" style="font-size: 11px;" type="text"/>
        </div>
        <div class="mb-4">
            <label class="block text-gray-800" for="password" style="font-size: 11px;">
                Password
            </label>
            <div class="relative">
                <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" id="password" placeholder="Enter your password" style="font-size: 11px;" type="password"/>
                <i class="fas fa-eye absolute right-3 top-3 text-gray-500 cursor-pointer">
                </i>
            </div>
        </div>
        <div class="flex items-center justify-between mb-4">
            <label class="flex items-center text-gray-800" style="font-size: 11px;">
                <input class="form-checkbox" type="checkbox"/>
                <span class="ml-2">
       Remember Me
      </span>
            </label>
            <a class="text-black" href="#" style="font-size: 11px;">
                Forgot Password?
            </a>
        </div>
        <button class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800" style="font-size: 12px;" type="submit">
            Login
        </button>
    </form>
</div>
</body>
</html>
