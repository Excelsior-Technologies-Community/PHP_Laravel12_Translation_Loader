<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;

class LanguageLineController extends Controller
{
    // LIST + SEARCH
    
    public function index(Request $request)
{
    $query = LanguageLine::query();

    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('key', 'LIKE', '%' . $request->search . '%')
              ->orWhere('group', 'LIKE', '%' . $request->search . '%');
        });
    }

    $translations = $query->orderBy('id', 'asc')->paginate(4);

    return view('translations.index', compact('translations'));
}

    // CREATE PAGE
    public function create()
    {
        return view('translations.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'group' => 'required',
            'key' => 'required',
            'en' => 'required',
        ]);

        LanguageLine::create([
            'group' => $request->group,
            'key' => $request->key,
            'text' => [
                'en' => $request->en,
                'hi' => $request->hi,
                'fr' => $request->fr,
            ]
        ]);

        return redirect()
            ->route('translations.index')
            ->with('success', 'Translation added successfully!');
    }

    // EDIT PAGE
    public function edit($id)
    {
        $translation = LanguageLine::findOrFail($id);
        return view('translations.edit', compact('translation'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $translation = LanguageLine::findOrFail($id);

        $translation->update([
            'group' => $request->group,
            'key' => $request->key,
            'text' => [
                'en' => $request->en,
                'hi' => $request->hi,
                'fr' => $request->fr,
            ]
        ]);

        return redirect()
            ->route('translations.index')
            ->with('success', 'Translation updated successfully!');
    }

    // DELETE
    public function destroy($id)
    {
        LanguageLine::findOrFail($id)->delete();

        return back()->with('success', 'Translation deleted successfully!');
    }
}