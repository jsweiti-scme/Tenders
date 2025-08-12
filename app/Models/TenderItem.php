<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderItem extends Model
{
    protected $fillable = ['tender_id', 'item_name', 'quantity', 'unit'];

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
}