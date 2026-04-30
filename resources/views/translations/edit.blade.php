<!DOCTYPE html>
<html>

<head>
    <title>Edit Translation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-pink-500 to-purple-600 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-lg">

        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">
            ✏️ Edit Translation
        </h2>

        <!-- Errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('translations.update', $translation->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <input name="group" value="{{ old('group', $translation->group) }}"
                class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-pink-400">

            <input name="key" value="{{ old('key', $translation->key) }}"
                class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-pink-400">

            <input name="en" value="{{ old('en', $translation->text['en'] ?? '') }}"
                class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-pink-400">

            <input name="hi" value="{{ old('hi', $translation->text['hi'] ?? '') }}"
                class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-pink-400">

            <input name="fr" value="{{ old('fr', $translation->text['fr'] ?? '') }}"
                class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-pink-400">

            <button type="submit" class="w-full bg-pink-600 text-white p-3 rounded-lg hover:bg-pink-700 transition">
                Update Translation
            </button>
        </form>

        <a href="{{ route('translations.index') }}" class="block text-center mt-4 text-pink-600 hover:underline">
            ← Back
        </a>

    </div>

</body>

</html>