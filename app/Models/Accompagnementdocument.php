<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Accompagnementdocument extends Model
{
    use AsSource, Attachable;

    protected $table = 'accompagnementdocuments';

    /**
     * @var array
     */
    protected $fillable = [
        'document_id',
        'accompagnement_id',
        'spotlight',
        'etat',
    ];
    
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function accompagnement()
    {
        return $this->belongsTo(Accompagnement::class);
    }


}
