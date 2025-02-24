<?php

namespace App\Http\Controllers\Item;

use App\Http\Requests\Item\CommentRequest;
use App\Models\Item\Comment;
use App\Models\Item\Item;
use App\Models\Item\Like;
use App\Models\Item\Purchase;
use App\Models\Item\Exhibition;
use App\Models\Profile\Profile;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ItemController extends Controller
{
    // 商品一覧画面の表示
    public function index(Request $request)
    {
        $page = $request->query('page');
        $keyword = $request->query('keyword');

        if (!auth()->check() && $page != 'mylist') {
            $items = Item::all();
            $purchases = Purchase::all();
            $page = 'recommend';
            return view('item.catalog', compact('items', 'purchases', 'page'));

        } elseif (!auth()->check() && $page == 'mylist') {
            return view('item.catalog', compact('page'));

        } elseif (auth()->check() && $page != 'mylist') {
            $profile = Profile::find(Auth::id());
            $items = Item::all();
            $purchases = Purchase::all();
            $exhibitions = Exhibition::where('profile_id', $profile->id)->get();
            $page = 'recommend';
            return view('item.catalog', compact('profile', 'items', 'purchases', 'exhibitions', 'page', 'keyword'));

        } elseif (auth()->check() && $page == 'mylist') {
            $profile = Profile::find(Auth::id());
            $items = Item::all();
            $purchases = Purchase::all();
            $exhibitions = Exhibition::where('profile_id', $profile->id)->get();
            $likes = Like::where('profile_id', $profile->id)->get();
            return view('item.catalog', compact('profile', 'items', 'purchases', 'exhibitions', 'likes', 'page', 'keyword'));
        }
    }


    // 商品詳細画面の表示
    public function show(Item $item)
    {
        $profile = Profile::find(Auth::id());
        return view('item.detail', compact('profile', 'item'));
    }


    // 商品詳細画面：いいね機能
    public function toggleLike(Item $item)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

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
        if (!auth()->check()) {
            return redirect('/login');
        }

        $profile = Profile::find(Auth::id());

        DB::beginTransaction();
        $comment = new Comment;
        $comment->fill([
            'profile_id' => $profile->id,
            'item_id'    => $item->id,
            'comment'    => $request->comment,
        ])->save();
        DB::commit();

        return redirect()->back();
    }


    // マイページ画面の表示
    public function mypage(Request $request)
    {
        $profile = Profile::find(Auth::id());
        $page = $request->query('page');

        if ($page == 'sell') {
            $item = Exhibition::where('profile_id', $profile->id)->get();
            return view('profile.mypage', compact('profile', 'item', 'page'));

        } elseif ($page == 'buy') {
            $item = Purchase::where('profile_id', $profile->id)->get();
            return view('profile.mypage', compact('profile', 'item', 'page'));

        } elseif (isset($profile)) {
            $item = Exhibition::where('profile_id', $profile->id)->get();
            $page = 'sell';
            return view('profile.mypage', compact('profile', 'item', 'page'));

        } else {
            return redirect('/')->with('message', 'ログインしてください');
        }
    }
}
