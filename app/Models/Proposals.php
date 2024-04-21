<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposals extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'announcement_id',
        'area_knowledge_id',
        'user_id',
        'state_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'proposals_user', 'proposals_id', 'user_id');
    }

    public function review()
    {
        return $this->belongsToMany(review::class, 'reviews');
    }

    public function announcement()
    {
        return $this->belongsTo(Announcements::class, 'announcement_id');
    }

    public function state()
    {
        return $this->belongsTo(ProposalStates::class, 'state_id');
    }


    public function area_knowledge()
    {
        return $this->belongsTo(Areas_knowledge::class, 'area_knowledge_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function fields()
    {
        $table = 'proposal_fields';
        return $this->belongsToMany(Fields::class, $table, 'proposals_id', 'fields_id');
    }
}
