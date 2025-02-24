<?php

namespace App\Http\Controllers\Item;

use App\Http\Requests\Item\ExhibitionEditRequest;
use App\Http\Requests\Item\ExhibitionRequest;
use App\Models\Item\Category;
use App\Models\Item\Item;
use App\Models\Profile\Profile;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExhibitionController extends Controller
{
    // 商品出品画面の表示
    public function create() {
        $categories = Category::all();
        return view('item.exhibition', compact('categories'));
    }


    // 商品出品画面（出品）
    public function store(ExhibitionRequest $request) {
        $user = Auth::id();
        $profile = Profile::find($user);

        $price = str_replace(',', '', $request->price);

        $file = $request->file('image');
        $file_name = $file->getClientOriginalName();
        $image_path = $file->storeAs('image/item', 'user' . $user . '_' . $file_name, 'public');

        DB::beginTransaction();
        $item = new Item;
        $item->fill([
            'name'      => $request->name,
            'brand'     => $request->brand,
            'price'     => $price,
            'detail'    => $request->detail,
            'image'     => $image_path,
            'condition' => $request->condition,
        ])->save();

        $item->categories()->syncWithoutDetaching($request->category);
        $profile->exhibitions()->syncWithoutDetaching($item->id);
        DB::commit();

        return redirect('/');
    }


    // 出品商品の編集画面（マイページ画面より遷移）
    public function edit(Item $item) {
        $categories = Category::all();
        return view('item.exhibition_edit', compact('categories', 'item'));
    }


    // 出品商品の更新（マイページ画面より遷移）
    public function update(ExhibitionEditRequest $request) {
        $user = Auth::id();
        $item = Item::find($request->id);

        $price = str_replace(',', '', $request->price);

        $file = $request->file('image');
        if (isset($file)) {
            $file_name = $file->getClientOriginalName();
            $image_path = $file->storeAs('image/item', 'user' . $user . '_' . $file_name, 'public');
            $item->update(['image' => $image_path]);
        }

        $item->update ([
            'name'      => $request->name,
            'brand'     => $request->brand,
            'price'     => $price,
            'detail'    => $request->detail,
            'condition' => $request->condition,
        ]);

        $item->categories()->detach();
        $item->categories()->syncWithoutDetaching($request->category);
        DB::commit();

        return redirect('/mypage')->with('message', '出品した商品を更新しました');
    }
}
