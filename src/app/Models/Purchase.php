<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'item_id',
		'status',
        'payment_method',
        'shipping_address',
    ];

    public function profile() {
        return $this->belongsTo(profile::class);
    }

    public function item() {
        return $this->belongsTo(item::class);
    }
}