<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Action extends Model
{
    use AsSource, Attachable;

    protected $table = 'actions';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'code',
        'point',
        'limite',
        'seuil',
        'ressourcetype_id',
        'spotlight',
        'etat',
    ];

    public function ressourcetype()
    {
        return $this->belongsTo(Ressourcetype::class);
    }

}
