<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 Translation Loader</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center p-6">

    <div class="bg-white/20 backdrop-blur-lg shadow-2xl rounded-3xl p-10 w-full max-w-xl text-center border border-white/30">

        <!-- Header -->
        <h1 class="text-4xl font-bold text-white mb-4">
            {{ __('messages.welcome') }}
        </h1>

        <p class="text-white/80 mb-8 text-lg">
            Laravel 12 Database Translation Loader
        </p>

        <!-- Language Switcher -->
        <div class="flex flex-wrap justify-center gap-4">

            <a href="/set-language/en"
               class="px-6 py-3 rounded-xl bg-white text-indigo-600 font-semibold shadow-md hover:scale-105 hover:bg-indigo-100 transition duration-300">
                🇺🇸 English
            </a>

            <a href="/set-language/fr"
               class="px-6 py-3 rounded-xl bg-white text-purple-600 font-semibold shadow-md hover:scale-105 hover:bg-purple-100 transition duration-300">
                🇫🇷 French
            </a>

            <a href="/set-language/hi"
               class="px-6 py-3 rounded-xl bg-white text-pink-600 font-semibold shadow-md hover:scale-105 hover:bg-pink-100 transition duration-300">
                🇮🇳 Hindi
            </a>

        </div>

        <!-- Footer -->
        <div class="mt-10 text-white/70 text-sm">
            Built with ❤️ using Laravel 12 & Translation Loader
        </div>

    </div>

</body>
</html>