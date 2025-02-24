<?php

namespace App\Models\Profile;

use App\Models\Item\Item;
use App\Models\Item\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'image',
        'postcode',
        'address',
        'building',
    ];

    public function comments() {
        return $this->belongsToMany(Item::class, 'comments', 'profile_id', 'item_id')
        ->as('comments')
        ->withPivot('comment');
    }

    public function likes() {
        return $this->belongsToMany(Item::class, 'likes', 'profile_id', 'item_id')->withTimestamps();
    }

    public function items() {
        return $this->hasMany(Item::class);
    }

    public function purchases() {
        return $this->belongsToMany(Item::class, 'purchases', 'profile_id', 'item_id')
        ->as('purchases')
        ->withPivot('purchase', 'shipping_address');
    }

    public function exhibitions() {
        return $this->belongsToMany(Item::class, 'exhibitions', 'profile_id', 'item_id')
        ->withTimestamps();
    }

    public function user() {
        return $this->belongsTo(user::class);
    }
}

