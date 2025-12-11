<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Ressourcetypeoffretype extends Model
{
    use AsSource, Attachable;

    protected $table = 'ressourcetypeoffretypes';

    /**
     * @var array
     */
    protected $fillable = [
        'ressourcetype_id',
        'offretype_id',
        'table_id',
        'spotlight',
        'etat',
    ];
    
    public function ressourcetype()
    {
        return $this->belongsTo(Ressourcetype::class);
    }

    public function offretype()
    {
        return $this->belongsTo(Offretype::class);
    }

}
