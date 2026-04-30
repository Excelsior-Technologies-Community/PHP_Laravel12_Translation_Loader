<!DOCTYPE html>
<html>

<head>
    <title>Add Translation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-indigo-500 to-purple-600 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-lg">

        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">
            ➕ Add Translation
        </h2>

        <!-- Errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('translations.store') }}" class="space-y-4">
            @csrf

            <input name="group" placeholder="Group"
                class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-indigo-400" value="{{ old('group') }}">

            <input name="key" placeholder="Key" class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-indigo-400"
                value="{{ old('key') }}">

            <input name="en" placeholder="English"
                class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-indigo-400" value="{{ old('en') }}">

            <input name="hi" placeholder="Hindi" class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-indigo-400"
                value="{{ old('hi') }}">

            <input name="fr" placeholder="French"
                class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-indigo-400" value="{{ old('fr') }}">

            <button type="submit" class="w-full bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 transition">
                Save Translation
            </button>
        </form>

        <a href="{{ route('translations.index') }}" class="block text-center mt-4 text-indigo-600 hover:underline">
            ← Back
        </a>

    </div>

</body>

</html>