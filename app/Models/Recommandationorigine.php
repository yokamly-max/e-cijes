<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Recommandationorigine extends Model
{
    use HasFactory, AsSource;

    protected $table = 'recommandationorigines'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
