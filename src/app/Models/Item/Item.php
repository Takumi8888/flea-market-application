<?php

namespace App\Models\Item;

use App\Models\Item\Category;
use App\Models\Item\Like;
use App\Models\Profile\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'price',
        'detail',
        'image',
        'condition',
    ];

    public function categories() {
        return $this->belongsToMany(Category::class, 'item_category', 'item_id', 'category_id')
        ->withTimestamps();
    }

    public function comments() {
        return $this->belongsToMany(Profile::class, 'comments', 'item_id', 'profile_id')
        ->as('comments')
        ->withPivot('comment');
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function profiles() {
        return $this->hasMany(Profile::class);
    }

    public function purchases() {
        return $this->belongsToMany(Profile::class, 'purchases', 'item_id', 'profile_id')
        ->as('purchases')
        ->withPivot('purchase', 'shipping_address');
    }

    public function exhibitions() {
        return $this->belongsToMany(Profile::class, 'exhibitions', 'item_id', 'profile_id')
        ->withTimestamps();
    }
}


