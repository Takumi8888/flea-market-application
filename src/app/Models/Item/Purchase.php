<?php

namespace App\Models\Item;

use App\Models\Item\Item;
use App\Models\Profile\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'item_id',
        'purchase',
        'shipping_address',
    ];

    public function profile() {
        return $this->belongsTo(profile::class);
    }

    public function item() {
        return $this->belongsTo(item::class);
    }
}
