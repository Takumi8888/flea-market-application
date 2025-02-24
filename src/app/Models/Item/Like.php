<?php

namespace App\Models\Item;

use App\Models\Item\Item;
use App\Models\Profile\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'item_id',
    ];

    public function profiles() {
        return $this->belongsTo(Profile::class);
    }

    public function items() {
        return $this->belongsTo(Item::class);
    }
}
