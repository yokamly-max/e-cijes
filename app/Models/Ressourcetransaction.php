<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Ressourcetransaction extends Model
{
    use AsSource, Attachable;

    protected $table = 'ressourcetransactions';

    /**
     * @var array
     */
    protected $fillable = [
        'montant',
        'reference',
        'ressourcecompte_id',
        'datetransaction',
        'operationtype_id',
        'spotlight',
        'etat',
    ];
    
    public function ressourcecompte()
    {
        return $this->belongsTo(Ressourcecompte::class);
    }

    public function operationtype()
    {
        return $this->belongsTo(Operationtype::class);
    }

}
