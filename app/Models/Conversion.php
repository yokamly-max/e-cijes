<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Conversion extends Model
{
    use AsSource, Attachable;

    protected $table = 'conversions';

    protected $appends = ['nom_complet'];

    /**
     * @var array
     */
    protected $fillable = [
        'taux',
        'ressourcetransaction_source_id',
        'ressourcetransaction_cible_id',
        'membre_id',
        'entreprise_id',
        'spotlight',
        'etat',
    ];
    
    public function ressourcetransactionsource()
    {
        return $this->belongsTo(Ressourcetransaction::class, 'ressourcetransaction_source_id');
    }
    
    public function ressourcetransactioncible()
    {
        return $this->belongsTo(Ressourcetransaction::class, 'ressourcetransaction_cible_id');
    }
    
    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }
    
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function getNomCompletAttribute(): string
    {
        $membre = $this->membre ? "{$this->membre->prenom} {$this->membre->nom}" : '';
        $entreprise = $this->entreprise ? $this->entreprise->nom : '';
        return trim("$membre - $entreprise");
    }


}
