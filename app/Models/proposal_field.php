<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proposal_field extends Model
{
    use HasFactory;

    protected $table = 'proposal_fields';

    protected $fillable = ['proposals_id', 'fields_id', 'info'];

    public function fields()
    {
        return $this->belongsTo(Fields::class, 'fields_id');
    }

    public function proposals()
    {
        return $this->belongsTo(Proposals::class, 'proposals_id');
    }
}
