<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_revisorDocument extends Model
{
    use HasFactory;

    protected $table = 'user_revisor_documents';

    protected $fillable = ['user_id', 'revisor_documents_id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documents()
    {
        return $this->belongsTo(RevisorDocuments::class, 'revisor_documents_id');
    }
}
