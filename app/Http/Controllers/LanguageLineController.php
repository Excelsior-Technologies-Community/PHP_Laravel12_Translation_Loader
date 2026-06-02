<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;
use App\Models\TranslationHistory;
use App\Models\MissingTranslation;

class LanguageLineController extends Controller
{
    public function index(Request $request)
    {
        $query = LanguageLine::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('key', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('group', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('text', 'LIKE', '%' . $request->search . '%');
            });
        }

        $translations = $query->orderBy('id', 'asc')->paginate(4);
        $missingTranslations = MissingTranslation::latest()->get();

        return view('translations.index', compact('translations', 'missingTranslations'));
    }

    public function create()
    {
        return view('translations.create');
    }

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
                'gu' => $request->gu,
            ]
        ]);

        MissingTranslation::where('group', $request->group)->where('key', $request->key)->delete();

        return redirect()
            ->route('translations.index')
            ->with('success', 'Translation added successfully!');
    }

    public function edit($id)
    {
        $translation = LanguageLine::findOrFail($id);
        return view('translations.edit', compact('translation'));
    }

    public function update(Request $request, $id)
    {
        $translation = LanguageLine::findOrFail($id);

        TranslationHistory::create([
            'language_line_id' => $translation->id,
            'text' => $translation->text,
        ]);

        $translation->update([
            'group' => $request->group,
            'key' => $request->key,
            'text' => [
                'en' => $request->en,
                'hi' => $request->hi,
                'gu' => $request->gu,
            ]
        ]);

        return redirect()
            ->route('translations.index')
            ->with('success', 'Translation updated successfully!');
    }

    public function updateInline(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|array'
        ]);

        $translation = LanguageLine::findOrFail($id);

        TranslationHistory::create([
            'language_line_id' => $translation->id,
            'text' => $translation->text,
        ]);

        $translation->update([
            'text' => $request->text
        ]);

        return response()->json(['success' => true, 'message' => 'Translation updated successfully']);
    }

    public function history($id)
    {
        $line = LanguageLine::findOrFail($id);
        $history = TranslationHistory::where('language_line_id', $id)->latest()->get();

        return response()->json([
            'line' => $line,
            'history' => $history
        ]);
    }

    public function rollback($id)
    {
        $history = TranslationHistory::findOrFail($id);
        $translation = LanguageLine::findOrFail($history->language_line_id);

        TranslationHistory::create([
            'language_line_id' => $translation->id,
            'text' => $translation->text,
        ]);

        $translation->update([
            'text' => $history->text
        ]);

        return redirect()->back()->with('success', 'Translation rolled back successfully');
    }

    public function destroy($id)
    {
        LanguageLine::findOrFail($id)->delete();

        return back()->with('success', 'Translation deleted successfully!');
    }
}