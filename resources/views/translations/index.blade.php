<!DOCTYPE html>
<html>

<head>
    <title>Translations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">🌍 Translations</h1>

            <a href="{{ route('translations.create') }}"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow">
                + Add
            </a>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- SEARCH -->
        <form method="GET" class="mb-6 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search key or group..."
                class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Search
            </button>
        </form>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Group</th>
                        <th class="p-3 text-left">Key</th>
                        <th class="p-3 text-left">EN</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($translations as $t)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-3">{{ $t->id }}</td>
                            <td class="p-3">{{ $t->group }}</td>
                            <td class="p-3 font-medium text-gray-700">{{ $t->key }}</td>
                            <td class="p-3 text-gray-600">{{ $t->text['en'] ?? '' }}</td>

                            <td class="p-3 text-center space-x-2">
                                <a href="{{ route('translations.edit', $t->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('translations.destroy', $t->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">
                                No translations found 😢
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-6">
            {{ $translations->links() }}
        </div>

    </div>

</body>

</html>