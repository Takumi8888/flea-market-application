<?php

namespace App\Models;

use App\Models\transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

	protected $fillable = [
		'profile_id',
		'item_id',
		'transaction_id',
		'message',
		'message_alert',
		'image',
	];

	public function transaction() {
		return $this->belongsTo(Transaction::class);
	}
}
