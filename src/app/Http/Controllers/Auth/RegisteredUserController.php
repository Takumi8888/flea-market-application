<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisteredUserController
{
	public function store(Request $request, CreateNewUser $creator)
	{
		event(new Registered($user = $creator->create($request->all())));
		session()->put('unauthenticated_user', $user);
		return redirect()->route('verification.notice');
	}
}