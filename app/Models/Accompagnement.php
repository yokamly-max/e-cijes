<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Accompagnement extends Model
{
    use AsSource, Attachable;

    protected $table = 'accompagnements';

    protected $appends = ['nom_complet'];

    /**
     * @var array
     */
    protected $fillable = [
        'membre_id',
        'entreprise_id',
        'accompagnementniveau_id',
        'dateaccompagnement',
        'accompagnementstatut_id',
        'spotlight',
        'etat',
    ];
    
    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }
    
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function accompagnementniveau()
    {
        return $this->belongsTo(Accompagnementniveau::class);
    }

    public function accompagnementstatut()
    {
        return $this->belongsTo(Accompagnementstatut::class);
    }

    public function getNomCompletAttribute(): string
    {
        $membre = $this->membre ? "{$this->membre->prenom} {$this->membre->nom}" : '';
        $entreprise = $this->entreprise ? $this->entreprise->nom : '';
        return trim("$membre - $entreprise");
    }

}
