<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantTender extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_id',
        'user_id'
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(ApplicantAnswer::class, 'user_id', 'user_id')
            ->where('tender_id', $this->tender_id);
    }

    public function applicantTenderItems()
    {
        return $this->hasMany(ApplicantTenderItem::class);
    }

    public function getTotalBidAmountAttribute()
    {
        return $this->applicantTenderItems->sum(function ($item) {
            return $item->price * $item->tenderItem->quantity;
        });
    }
}
