<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Entreprisemembre extends Model
{
    use AsSource, Attachable;

    protected $table = 'entreprisemembres';

    /**
     * @var array
     */
    protected $fillable = [
        'fonction',
        'bio',
        'membre_id',
        'entreprise_id',
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

}
