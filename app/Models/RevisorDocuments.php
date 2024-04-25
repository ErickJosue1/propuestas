<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisorDocuments extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        $table = 'user_revisor_documents';
        return $this->belongsToMany(User::class, $table, 'revisor_documents_id', 'user_id');
    }
}
