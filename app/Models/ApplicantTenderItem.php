<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantTenderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_tender_id',
        'tender_item_id',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function applicantTender()
    {
        return $this->belongsTo(ApplicantTender::class);
    }

    public function tenderItem()
    {
        return $this->belongsTo(TenderItem::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->price * $this->tenderItem->quantity;
    }

    public function award()
    {
        return $this->hasOne(TenderItemAward::class);
    }

    public function getCompanyInfo()
    {
        return $this->applicantTender->user->companyInfo ?? null;
    }
}
