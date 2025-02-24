<?php

namespace App\Http\Controllers\Profile;

use App\Models\Item\Item;
use App\Models\Profile\Profile;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    // 配送先変更画面の表示
    public function edit(Item $item)
    {
        $profile = Profile::find(Auth::id());
        return view('profile.address', compact('profile', 'item'));
    }


    // 配送先変更画面（編集）→ 商品購入画面（編集後表示）
    public function update(Request $request, Item $item)
    {
        Validator::extend('postcode', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9]{3}-?[0-9]{4}$/', $value);
        });

        $request->validate([
            'postcode' => ['required', 'postcode', 'min:8'],
            'address'  => 'required',
            'building' => 'required',
        ]);

        $profile = Profile::find(Auth::id());
        unset($profile['_token']);

        $profile->update([
            'postcode' => $request->postcode,
            'address'  => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase.create', ['item' => $item->id]);
    }
}
