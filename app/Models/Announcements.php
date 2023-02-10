<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'num_announcement', 'y_announcement', 'status', 'institutions_id'];

    public function institutions()
    {
        return $this->belongsTo(institutions::class, 'institutions_id');
    }

    public function documents_supporting()
    {
        $table = 'announcement_document_supporting';
        return $this->belongsToMany(Document_Supporting::class, $table, 'announcements_id', 'document_supporting_id');
    }
}