<!DOCTYPE html>
<html>

<head>
    <title>Translations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">🌍 Translations</h1>

            <a href="{{ route('translations.create') }}"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow">
                + Add
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($missingTranslations) && $missingTranslations->count() > 0)
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                <h3 class="font-bold text-red-800 mb-2">⚠️ Auto-Detected Missing Translation Keys</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-red-200 text-red-800">
                                <th class="pb-2">Group</th>
                                <th class="pb-2">Key</th>
                                <th class="pb-2 text-center">Count</th>
                                <th class="pb-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($missingTranslations as $missing)
                                <tr class="border-b border-red-100 last:border-none">
                                    <td class="py-2"><span class="bg-red-100 px-2 py-0.5 rounded text-xs font-mono">{{ $missing->group }}</span></td>
                                    <td class="py-2 font-mono font-medium">{{ $missing->key }}</td>
                                    <td class="py-2 text-center"><span class="bg-red-200 text-red-800 px-2 py-0.5 rounded-full text-xs font-bold">{{ $missing->count }} times</span></td>
                                    <td class="py-2 text-center">
                                        <a href="{{ route('translations.create') }}?group={{ $missing->group }}&key={{ $missing->key }}" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs font-medium shadow-sm">Create</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <form method="GET" action="{{ route('translations.index') }}" class="mb-6 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search key or group..."
                class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Search
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Group</th>
                        <th class="p-3 text-left">Key</th>
                        <th class="p-3 text-left">Translations (Languages)</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($translations as $t)
                        <tr class="border-t hover:bg-gray-50 transition" id="row-{{ $t->id }}">
                            <td class="p-3 align-top">{{ $t->id }}</td>
                            <td class="p-3 align-top"><span class="bg-gray-200 px-2 py-0.5 rounded text-xs font-mono text-gray-700">{{ $t->group }}</span></td>
                            <td class="p-3 align-top font-medium text-gray-700 font-mono">{{ $t->key }}</td>
                            <td class="p-3">
                                @foreach(['en', 'gu', 'hi'] as $lang)
                                    <div class="flex items-center gap-2 mb-1.5 last:mb-0">
                                        <span class="text-xs font-bold text-gray-500 bg-gray-200 px-1.5 py-1 rounded uppercase min-w-[30px] text-center">{{ $lang }}</span>
                                        <input type="text" class="w-full border border-gray-300 p-1 px-2 rounded-md text-sm text-gray-700 focus:ring-1 focus:ring-blue-400 focus:outline-none translation-input" data-id="{{ $t->id }}" data-lang="{{ $lang }}" value="{{ $t->text[$lang] ?? '' }}">
                                    </div>
                                @endforeach
                            </td>

                            <td class="p-3 text-center align-top space-y-1.5">
                                <button onclick="saveInline({{ $t->id }})" class="block w-full bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-medium shadow-sm">
                                    Quick Save
                                </button>
                                <button onclick="viewHistory({{ $t->id }})" class="block w-full bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded text-xs font-medium shadow-sm">
                                    History
                                </button>
                                <form action="{{ route('translations.destroy', $t->id) }}" method="POST"
                                    class="block w-full"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @choose
                                    @method('DELETE')
                                    <button class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium shadow-sm">
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

        <div class="mt-6">
            {{ $translations->appends(request()->query())->links() }}
        </div>

    </div>

    <div id="historyModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[85vh] flex flex-col">
            <div class="p-4 border-b flex justify-between items-center bg-gray-50 rounded-t-xl">
                <h3 class="text-lg font-bold text-gray-800">Version History Log</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            <div class="p-4 overflow-y-auto space-y-3 flex-1" id="history-container"></div>
        </div>
    </div>

    <script>
        async function saveInline(id) {
            const inputs = document.querySelectorAll(`.translation-input[data-id="${id}"]`);
            const text = {};
            inputs.forEach(input => {
                text[input.dataset.lang] = input.value;
            });

            try {
                const response = await fetch(`/translations/inline/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ text })
                });
                const data = await response.json();
                if (data.success) {
                    alert(data.message);
                }
            } catch (error) {
                console.error(error);
            }
        }

        async function viewHistory(id) {
            try {
                const response = await fetch(`/translations/history/${id}`);
                const data = await response.json();
                const container = document.getElementById('history-container');
                container.innerHTML = '';

                if (!data.history || data.history.length === 0) {
                    container.innerHTML = '<p class="text-gray-500 text-center py-6">No previous logs found for this item.</p>';
                } else {
                    data.history.forEach(item => {
                        let innerLogs = '';
                        Object.keys(item.text).forEach(lang => {
                            innerLogs += `<div><span class="text-xs font-bold uppercase bg-gray-100 px-1 rounded text-gray-500">${lang}:</span> <span class="text-sm text-gray-700">${item.text[lang]}</span></div>`;
                        });

                        container.innerHTML += `
                            <div class="border border-amber-200 rounded-lg p-3 bg-amber-50 shadow-sm">
                                <div class="text-xs text-gray-500 mb-1 font-medium">Saved: ${new Date(item.created_at).toLocaleString()}</div>
                                <div class="space-y-1 mb-2.5 bg-white p-2 rounded border border-amber-100">${innerLogs}</div>
                                <form method="POST" action="/translations/rollback/${item.id}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold py-1 px-3 rounded shadow-sm transition">Rollback to this version</button>
                                </form>
                            </div>
                        `;
                    });
                }
                document.getElementById('historyModal').classList.remove('hidden');
            } catch (error) {
                console.error(error);
            }
        }

        function closeModal() {
            document.getElementById('historyModal').classList.add('hidden');
        }
    </script>

</body>

</html>