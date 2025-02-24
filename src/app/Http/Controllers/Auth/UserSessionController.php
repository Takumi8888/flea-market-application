<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserSessionController extends Controller
{
    // ヘッダー：「ログイン」ボタン → ログイン画面
    public function login() {
        return view('auth.login');
    }


    // ヘッダー：「ログアウト」ボタン → ログイン画面
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
