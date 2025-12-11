<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Membre extends Model
{
    use AsSource, Attachable;

    protected $table = 'membres';

    protected $appends = ['nom_complet'];

    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'membrestatut_id',
        'vignette',
        'membretype_id',
        'user_id',
        'pays_id',
        'telephone',
        'etat',
    ];
    
    public function membrestatut()
    {
        return $this->belongsTo(Membrestatut::class);
    }

    public function membretype()
    {
        return $this->belongsTo(Membretype::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

    public function getNomCompletAttribute()
    {
        return trim("{$this->prenom} {$this->nom}");
    }



}
