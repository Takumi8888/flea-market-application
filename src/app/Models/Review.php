<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

	protected $fillable = [
		'profile_id',
		'item_id',
		'transaction_partner',
		'status',
		'review',
	];
}