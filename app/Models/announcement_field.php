<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class announcement_field extends Model
{
    use HasFactory;

    protected $table = 'announcement_fields';

    protected $fillable = ['announcements_id', 'fields_id'];

    public function fields()
    {
        return $this->belongsTo(Fields::class, 'fields_id');
    }

    public function announcements()
    {
        return $this->belongsTo(Announcements::class, 'announcements_id');
    }
}