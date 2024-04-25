<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisorStatus extends Model
{
    use HasFactory;

    protected $table = 'revisor_statuses';

    protected $fillable = ['user_id', 'state_id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function states()
    {
        return $this->belongsTo(ProposalStates::class, 'state_id');
    }
}
