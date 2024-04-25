<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalStates extends Model
{
    use HasFactory;

    protected $fillable = ['state'];

    public function users()
    {
        $table = 'revisor_statuses';
        return $this->belongsToMany(User::class, $table, 'state_id', 'user_id');
    }
}
