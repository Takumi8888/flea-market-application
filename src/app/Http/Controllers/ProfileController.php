<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileEditRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // プロフィール設定画面の表示
    public function create()
    {
        $profile = Profile::find(Auth::id());
        return view('profile', compact('profile'));
    }


    // プロフィール設定画面（初回）→ 商品一覧画面
    public function store(ProfileRequest $request)
    {
        $user = Auth::id();

		$image = $request->file('user_image');
		$image_name =  'profile' . $user . '.' . $image->getClientOriginalExtension();
		$image_url = Storage::putFileAs('public/image/profile', $image, $image_name);

		profile::create([
            'user_id'       => $user,
            'user_name'     => $request->user_name,
			'user_image'    => $image_url,
			'user_postcode' => $request->user_postcode,
			'user_address'  => $request->user_address,
			'user_building' => $request->user_building,
		]);

        return redirect('/');
    }


    // プロフィール設定画面の表示（編集）
    public function edit()
    {
        $profile = Profile::find(Auth::id());
        return view('profile', compact('profile'));
    }


   // プロフィール設定画面（編集）→ プロフィール設定画面（編集後表示）
    public function update(ProfileEditRequest $request)
    {
        $user = Auth::id();
        $profile = Profile::find($user);
		$image = $request->file('user_image');

        if (isset($image)){
			$image_name =  'profile' . $user . '.' . $image->getClientOriginalExtension();
			$image_url = Storage::putFileAs('public/image/profile', $image, $image_name);
            $profile->update(['user_image' => $image_url]);
        }

        $profile->update ([
            'user_name'     => $request->user_name,
			'user_postcode' => $request->user_postcode,
			'user_address'  => $request->user_address,
			'user_building' => $request->user_building,
        ]);

        return redirect('/mypage/profile')->with('message', '更新しました');
    }


	// 配送先変更画面の表示
	public function addressEdit(Item $item)
	{
		$profile = Profile::find(Auth::id());
		return view('profile', compact('profile', 'item'));
	}


	// 配送先変更画面（編集）→ 商品購入画面（編集後表示）
	public function addressUpdate(AddressRequest $request, Item $item)
	{
		$profile = Profile::find(Auth::id());
		unset($profile['_token']);

		$profile->update([
			'user_postcode' => $request->user_postcode,
			'user_address'  => $request->user_address,
			'user_building' => $request->user_building,
		]);

		return redirect()->route('purchase.create', ['item' => $item->id]);
	}
}
