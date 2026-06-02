<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationHistory extends Model
{
    protected $fillable = ['language_line_id', 'text'];

    protected $casts = [
        'text' => 'array',
    ];

    public function languageLine()
    {
        return $this->belongsTo(LanguageLine::class, 'language_line_id');
    }
}