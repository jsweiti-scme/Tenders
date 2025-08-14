<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TenderItemAward extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_id',
        'tender_item_id',
        'winner_user_id',
        'applicant_tender_item_id',
        'awarded_price',
        'awarded_quantity',
        'notes',
        'awarded_at',
        'awarded_by'
    ];

    protected $casts = [
        'awarded_price' => 'decimal:3',
        'awarded_quantity' => 'decimal:3',
        'awarded_at' => 'datetime'
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function tenderItem()
    {
        return $this->belongsTo(TenderItem::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_user_id');
    }

    public function applicantTenderItem()
    {
        return $this->belongsTo(ApplicantTenderItem::class);
    }

    public function awardedBy()
    {
        return $this->belongsTo(User::class, 'awarded_by');
    }
}
