<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderItem extends Model
{
    protected $fillable = ['tender_id', 'item_name', 'quantity', 'unit', 'award_status'];

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }

    public function applicantTenderItems()
    {
        return $this->hasMany(ApplicantTenderItem::class, 'tender_item_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function award()
    {
        return $this->hasOne(TenderItemAward::class);
    }

    public function applicantItems()
    {
        return $this->hasMany(ApplicantTenderItem::class);
    }

    // دوال مساعدة
    public function isAwarded()
    {
        return $this->award_status === 'awarded';
    }

    public function getLowestBid()
    {
        return $this->applicantItems()
            ->orderBy('price', 'asc')
            ->first();
    }

    public function getBidsWithCompanies()
    {
        return $this->applicantItems()
            ->with([
                'applicantTender.user.companyInfo'
            ])
            ->orderBy('price', 'asc')
            ->get();
    }

    public function getBidsCount()
    {
        return $this->applicantItems()->count();
    }
}
