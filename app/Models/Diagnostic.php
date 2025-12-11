<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Diagnostic extends Model
{
    use AsSource, Attachable;

    protected $table = 'diagnostics';

    protected $appends = ['nom_complet'];


    /**
     * @var array
     */
    protected $fillable = [
        'scoreglobal',
        'commentaire',
        'accompagnement_id',
        'diagnostictype_id',
        'diagnosticstatut_id',
        'membre_id',
        'entreprise_id',
        'spotlight',
        'etat',
    ];
    
    public function accompagnement()
    {
        return $this->belongsTo(Accompagnement::class);
    }

    public function diagnostictype()
    {
        return $this->belongsTo(Diagnostictype::class);
    }

    public function diagnosticstatut()
    {
        return $this->belongsTo(Diagnosticstatut::class);
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
        return trim("Diagnostic #{$this->id} - $membre - $entreprise (Score: {$this->scoreglobal})");
    }


}
