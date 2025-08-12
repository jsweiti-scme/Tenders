<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderCommitte extends Model
{
    use HasFactory;
    protected $fillable = [
        'tender_id',
        'user_id',
        'committee_type', // internal or external
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }

    public function scopeInternal($query)
    {
        return $query->where('committee_type', 'internal');
    }
    public function scopeExternal($query)
    {
        return $query->where('committee_type', 'external');
    }
}