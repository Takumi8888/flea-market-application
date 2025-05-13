<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
		'user_image',
		'user_postcode',
		'user_address',
		'user_building',
    ];

    public function comments() {
        return $this->belongsToMany(Item::class, 'comments', 'profile_id', 'item_id')
        ->as('comments')
        ->withPivot('comment');
    }

	public function exhibitions() {
		return $this->belongsToMany(Item::class, 'exhibitions', 'profile_id', 'item_id')
		->as('exhibitions')
		->withPivot('status');
	}

    public function likes() {
        return $this->belongsToMany(Item::class, 'likes', 'profile_id', 'item_id')
		->withTimestamps();
    }

    public function items() {
        return $this->hasMany(Item::class);
    }

    public function purchases() {
        return $this->belongsToMany(Item::class, 'purchases', 'profile_id', 'item_id')
        ->as('purchases')
		->withPivot('status', 'payment_method', 'shipping_address');
    }

	public function transactions() {
		return $this->belongsToMany(Item::class, 'transactions', 'profile_id', 'item_id')
		->as('transactions')
		->withPivot('exhibitor', 'purchaser', 'status');
	}

    public function user() {
        return $this->belongsTo(user::class);
    }
}