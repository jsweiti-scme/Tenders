<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantTenderItem extends Model
{
    protected $fillable = ['applicant_tender_id', 'tender_item_id', 'price'];

    public function applicantTender()
    {
        return $this->belongsTo(ApplicantTender::class);
    }

    public function tenderItem()
    {
        return $this->belongsTo(TenderItem::class);
    }
}