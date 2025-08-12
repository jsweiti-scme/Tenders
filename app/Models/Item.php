<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'description', 'unit'];

    public function tenderItems()
    {
        return $this->hasMany(TenderItem::class);
    }
}