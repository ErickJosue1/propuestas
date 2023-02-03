<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document_Supporting extends Model
{
    use HasFactory;

    protected $table = 'document_supportings';
    
    protected $fillable = ['name'];

}
