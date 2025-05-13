<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Exhibition;
use App\Models\Item;
use App\Models\Like;
use App\Models\Message;
use App\Models\Review;
use App\Models\transaction;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    // 商品一覧画面の表示
    public function index(Request $request)
    {
        $page = $request->query('page');

        if (!auth()->check() && $page != 'mylist') {
            $page = 'recommend';
			$exhibitions = Exhibition::get();
			$count = count($exhibitions);
			return view('catalog', compact('page', 'exhibitions', 'count'));

        } elseif (!auth()->check() && $page == 'mylist') {
            return view('catalog', compact('page'));

        } elseif (auth()->check() && $page != 'mylist') {
			$page = 'recommend';
			$profile = Profile::find(Auth::id());
			$exhibitions = Exhibition::where('profile_id', '!=', $profile->id)->get();
			$count = count($exhibitions);
            return view('catalog', compact('page', 'profile', 'exhibitions', 'count'));

        } elseif (auth()->check() && $page == 'mylist') {
            $profile = Profile::find(Auth::id());
			$likes = Like::where('profile_id', $profile->id)->get();
			$count = count($likes);
            return view('catalog', compact('page', 'profile', 'likes', 'count'));
        }
    }


    // 商品詳細画面の表示（出品中）
    public function show(Item $item)
    {
        $profile = Profile::find(Auth::id());
        return view('detail', compact('profile', 'item'));
    }

	// 商品詳細画面の表示（購入済み）
	public function buyItem(Item $item)
	{
		$profile = Profile::find(Auth::id());
		return view('detail', compact('profile', 'item'));
	}


    // 商品詳細画面：いいね機能
    public function toggleLike(Item $item)
    {
        $profile = Profile::find(Auth::id());
        $like = $item->likes()->where('profile_id', $profile->id);

        if ($like->exists()) {
            $like->delete();
        } else {
            $item->likes()->create(['profile_id' => $profile->id]);
        }

        return redirect()->back();
    }


    // 商品詳細画面：コメント機能
    public function comment(CommentRequest $request, Item $item)
    {
        $profile = Profile::find(Auth::id());

        Comment::create([
            'profile_id' => $profile->id,
            'item_id'    => $item->id,
            'comment'    => $request->comment,
        ]);

        return redirect()->back();
    }


    // マイページ画面の表示
    public function mypage(Request $request)
    {
		$page = $request->query('page');
        $profile = Profile::find(Auth::id());

		// レビュー
		$review = Review::where('transaction_partner', $profile->id)->get();
		$count = count($review);
		$total_review_number = 0;
		if ($count >= 1) {
			for ($i = 0; $i < $count; $i++) {
				$review_number = $review[$i]->review;
				$total_review_number += $review_number;
			}
			$overall_rating = round($total_review_number / $count);
		} elseif ($count == 0) {
			$overall_rating = 0;
		}

		// 新規通知総数
		$transaction_items = Transaction::where('profile_id', $profile->id)->where('status', 1)->latest('updated_at')->get();
		if (isset($transaction_items)) {
			$messages = [];
			foreach ($transaction_items as $transaction_item) {
				$transaction_partner_item = Transaction::where('profile_id', '!=', $profile->id)
				->where('item_id', $transaction_item->item_id)->where('status', 1)->first();
				if (isset($transaction_partner_item)) {
					$transaction_partner_message = Message::where('profile_id', '!=', $profile->id)
						->where('item_id', $transaction_partner_item->item_id)->where('message_alert', 1)->first();
					if (isset($transaction_partner_message)) {
						$messages[] = $transaction_partner_message;
					}
				}
			}

			if (isset($messages)) {
				$messages_count = count($messages);
			} else {
				$messages_count = 0;
			}

			// 新規取引カウント
			foreach ($transaction_items as $transaction_item) {
				$new_transactions = Message::where('profile_id', $profile->id)->where('item_id', $transaction_item->item_id)->get();
				$new_transactions_count = count($new_transactions);
				if ($new_transactions_count == 0) {
					$messages_count += 1;
				}
			}
		}

		return view('mypage', compact('page', 'profile', 'overall_rating', 'transaction_items', 'messages_count'));
    }
}
