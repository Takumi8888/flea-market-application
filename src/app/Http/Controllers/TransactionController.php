<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Mail\SendMail;
use App\Models\Exhibition;
use App\Models\Item;
use App\Models\Message;
use App\Models\Purchase;
use App\Models\Review;
use App\Models\transaction;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class TransactionController extends Controller
{
	// 取引チャット画面：表示
	public function create(Request $request, $tag, $item)
	{
		$profile = Profile::find(Auth::id());

		if ($tag == 'sell') {
			$purchaser_id = Purchase::where('item_id', $item)->first()->profile_id;
			$partner = Profile::find($purchaser_id);
		} elseif ($tag == 'buy') {
			$exhibitor_id = Exhibition::where('item_id', $item)->first()->profile_id;
			$partner = Profile::find($exhibitor_id);
		}

		$other_items = Transaction::where('profile_id', $profile->id)->where('status', 1)->get();
		$user_transaction = Transaction::where('profile_id', $profile->id)->where('item_id', $item)->first();
		$messages = Message::where('item_id', $item)->get();

		// 既読機能
		$partner_transaction = Transaction::where('profile_id', '!=', $profile->id)->where('item_id', $item)->first();
		$transaction_messages = Message::where('transaction_id', $partner_transaction->id)->get();
		foreach ($transaction_messages as $transaction_message) {
			if ($transaction_message->message_alert == 1) {
				$transaction_message->update(['message_alert' => 0]);
			}
		}

		$item = Item::find($item);

		return view('transaction', compact('tag', 'item', 'profile', 'partner', 'other_items', 'user_transaction', 'partner_transaction', 'messages'));
	}


	// 取引チャット画面：取引完了・レビュー（購入者）
	public function store(Request $request, $tag, $item)
	{
		// DB登録・更新
		$profile = Profile::find(Auth::id());

		$exhibitor_id = Exhibition::where('item_id', $item)->first()->profile_id;
		$partner = Profile::find($exhibitor_id);
		Transaction::where('profile_id', $profile->id)->where('item_id', $item)->first()->update(['status' => 2]);

		Review::create([
			'profile_id'          => $profile->id,
			'item_id'             => $item,
			'transaction_partner' => $partner->id,
			'review'              => $request->review,
		]);

		// メール送信（出品者宛）
		$name = $profile->user_name;
		$partner_user = User::where('id', $partner->user_id)->first();
		$to = [
			[
				'name'  => $partner_user->name,
				'email' => $partner_user->email,
			]
		];
		$exhibition_item = Item::where('id', $item)->first();

		$purchaser_review = Review::where('profile_id', $profile->id)->where('item_id', $exhibition_item->id)
		->where('transaction_partner', $partner_user->id)->first();
		$transaction_partner = $partner->user_name;
		$review = $purchaser_review->review;

		Mail::to($to)->send(new SendMail($name, $exhibition_item, $transaction_partner, $review));

		return redirect('/mypage?page=transaction');
	}


	// 取引チャット画面：取引完了・レビュー（出品者）
	public function review(Request $request, $tag, $item)
	{
		$profile_id = Profile::find(Auth::id())->id;

		$purchaser_id = Purchase::where('item_id', $item)->first()->profile_id;
		$partner_id = Profile::find($purchaser_id)->id;

		Exhibition::where('item_id', $item)->first()->update(['status' => 3]);
		Purchase::where('item_id', $item)->first()->update(['status' => 2]);
		Transaction::where('profile_id', $profile_id)->where('item_id', $item)->first()->update(['status' => 2]);

		Review::create([
			'profile_id'          => $profile_id,
			'item_id'             => $item,
			'transaction_partner' => $partner_id,
			'review'              => $request->review,
		]);

		return redirect('/mypage?page=transaction');
	}


	// 取引チャット画面：新規チャット送信
	public function Message(MessageRequest $request, $tag, $item)
	{
		$user = Auth::id();
		$profile_id = Profile::find(Auth::id())->id;
		$transaction_id = Transaction::where('profile_id', $profile_id)->where('item_id', $item)->first()->id;

		$image = $request->file('image');
		if (isset($image)) {
			$image_name =  'user' . $user . '_' . $image->getClientOriginalName();
			$image_url = Storage::putFileAs('public/image/message', $image, $image_name);
		} else {
			$image_url = null;
		}

		Message::create([
			'profile_id'     => $profile_id,
			'item_id'        => $item,
			'transaction_id' => $transaction_id,
			'message'        => $request->message,
			'message_alert'  => 1,
			'image'          => $image_url,
		]);

		return redirect()->route('transaction.create', ['tag' => $tag, 'item' => $item]);
	}


	// 取引チャット画面：既存チャット編集
	public function update(Request $request, $tag, $item, $message)
	{
		if (isset($request->message)) {
			$message = Message::find($message);
			$message->update([
				'message' => $request->message,
			]);
			return redirect()->route('transaction.create', ['tag' => $tag, 'item' => $item]);
		} else {
			return redirect()->route('transaction.create', ['tag' => $tag, 'item' => $item])->with('message', '本文を入力してください');
		}
	}


	// 取引チャット画面：既存チャット削除
	public function destroy($tag, $item, $message)
	{
		Message::find($message)->delete();
		return redirect()->route('transaction.create', ['tag' => $tag, 'item' => $item]);
	}











}
