<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class announcement_revisor_document extends Model
{
    use HasFactory;

    protected $table = 'announcement_revisor_documents';

    protected $fillable = ['announcements_id', 'revisor_documents_id'];

    public function announcements(){
        return $this->belongsTo(Announcements::class,'announcements_id');
    }

    public function revisor_documents(){
        return $this->belongsTo(RevisorDocuments::class,'revisor_documents_id');
    }

}
