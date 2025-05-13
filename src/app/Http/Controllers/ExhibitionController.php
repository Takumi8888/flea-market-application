<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionEditRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Exhibition;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExhibitionController extends Controller
{
	// 商品出品画面の表示
	public function create()
	{
		$categories = Category::all();
		return view('exhibition', compact('categories'));
	}


	// 商品出品画面（出品）
	public function store(ExhibitionRequest $request)
	{
		$user = Auth::id();

		$image = $request->file('image');
		$image_name =  'user' . $user . '_' . $image->getClientOriginalName();
		$image_url = Storage::putFileAs('public/image/item', $image, $image_name);

		$item = Item::create([
			'name'      => $request->name,
			'brand'     => $request->brand,
			'price'     => str_replace(',', '', $request->price),
			'detail'    => $request->detail,
			'image'     => $image_url,
			'condition' => $request->condition,
		]);

		Exhibition::create([
			'profile_id' => Profile::find($user)->id,
			'item_id'    => $item->id,
			'status'     => 1,
		]);

		$item->categories()->syncWithoutDetaching($request->category);

		return redirect('/');
	}

	// 出品商品の編集画面（マイページ画面より遷移）
	public function edit(Item $item)
	{
		$categories = Category::all();
		$status = Exhibition::where('item_id', $item->id)->first()->status;
		return view('exhibition', compact('categories', 'item', 'status'));
	}


	// 出品商品の更新（マイページ画面より遷移）
	public function update(ExhibitionEditRequest $request)
	{
		$user = Auth::id();
		$item = Item::find($request->id);

		$image = $request->file('image');
		if (isset($image)) {
			$image_name =  'user' . $user . '_' . $image->getClientOriginalName();
			$image_url = Storage::putFileAs('public/image/item', $image, $image_name);
			$item->update(['image' => $image_url]);
		}

		$item->update([
			'name'      => $request->name,
			'brand'     => $request->brand,
			'price'     => str_replace(',', '', $request->price),
			'detail'    => $request->detail,
			'condition' => $request->condition,
		]);

		$item->categories()->detach();
		$item->categories()->syncWithoutDetaching($request->category);

		return redirect()->route('exhibition.edit', compact('item'))->with('message', '更新しました');
	}
}
