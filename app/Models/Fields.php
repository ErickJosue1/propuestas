<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function announcements()
    {
        $table = 'announcement_fields';
        return $this->belongsToMany(Announcements::class, $table, 'fields_id', 'announcements_id');
    }
}
