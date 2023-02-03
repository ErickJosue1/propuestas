<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;

    protected $fillable = ['name','num_announcement','y_announcement','status','institutions_id'];

    public function institutions(){
        return $this->belongsTo(institutions::class,'institutions_id');
    }

}
