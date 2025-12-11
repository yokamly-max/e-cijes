<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Entreprise extends Model
{
    use AsSource, Attachable;

    protected $table = 'entreprises';

    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'adresse',
        'description',
        'secteur_id',
        'vignette',
        'entreprisetype_id',
        'pays_id',
        'supabase_startup_id',
        'spotlight',
        'etat',
    ];
    
    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    public function entreprisetype()
    {
        return $this->belongsTo(Entreprisetype::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
