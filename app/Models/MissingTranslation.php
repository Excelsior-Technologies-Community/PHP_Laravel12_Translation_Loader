<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissingTranslation extends Model
{
    protected $table = 'missing_translations';
    protected $fillable = ['group', 'key', 'count'];
}