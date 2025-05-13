<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;

	protected $fillable = [
		'profile_id',
		'item_id',
		'purchaser',
		'exhibitor',
		'status',
	];

	public function messages() {
		return $this->hasMany(Message::class);
	}
}