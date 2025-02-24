<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\Profile\AddressRequest;
use App\Http\Requests\Profile\ProfileRequest;
use App\Models\Profile\Profile;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // プロフィール設定画面の表示
    public function create()
    {
        $profile = Profile::find(Auth::id());
        return view('profile.profile', compact('profile'));
    }


    // プロフィール設定画面（初回）→ 商品一覧画面
    public function store(ProfileRequest $request)
    {
        $user = Auth::id();
        $file = $request->file('image');

        $extension = $file->getClientOriginalExtension();
        $image = $file->storeAs('image/profile', 'profile' . $user . '.' . $extension, 'public');

        $profile = [
            'user_id'  => $user,
            'user_name' => $request->user_name,
            'image'    => $image,
            'postcode' => $request->postcode,
            'address'  => $request->address,
            'building' => $request->building,
        ];

        Profile::create($profile);

        return redirect('/');
    }


    // プロフィール設定画面の表示（編集）
    public function edit()
    {
        $profile = Profile::find(Auth::id());
        return view('profile.profile', compact('profile'));
    }


   // プロフィール設定画面（編集）→ プロフィール設定画面（編集後表示）
    public function update(AddressRequest $request)
    {
        $user = Auth::id();
        $profile = Profile::find($user);
        $file = $request->file('image');

        if (isset($file)){
            $extension = $file->getClientOriginalExtension();
            $image = $file->storeAs('image/profile', 'profile' . $user . '.' . $extension, 'public');
            $profile->update(['image' => $image]);
        }

        $profile->update ([
            'user_name' => $request->user_name,
            'postcode' => $request->postcode,
            'address'  => $request->address,
            'building' => $request->building,
        ]);

        return redirect('/mypage/profile')->with('message', 'プロフィールを更新しました');
    }
}
