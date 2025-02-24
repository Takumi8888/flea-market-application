<?php

namespace App\Http\Controllers\Item;

use App\Http\Requests\Item\PurchaseRequest;
use App\Models\Item\Item;
use App\Models\Item\Purchase;
use App\Models\Profile\Profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    // 商品購入画面の表示
    public function create(Item $item) {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $profile = Profile::find(Auth::id());
        return view('item.purchase', compact('profile', 'item'));
    }


    // 商品購入画面（購入）
    public function store(PurchaseRequest $request, Item $item) {
        if ($request->purchase == 1) {
            $profile = Profile::find(Auth::id());
            $shipping_address = $profile->postcode . $profile->address . $profile->building;

            DB::beginTransaction();
            $purchase = new Purchase();
            $purchase->fill([
                'profile_id'       => $profile->id,
                'item_id'          => $item->id,
                'purchase'         => $request->purchase,
                'shipping_address' => $shipping_address,
            ])->save();
            DB::commit();
            return redirect('/');

        }elseif ($request->purchase == 2) {
            return view('item.stripe', compact('item'));
        }
    }


    // 商品購入画面の表示
    public function stripeCreate(Item $item) {
        $profile = Profile::find(Auth::id());
        return view('item.purchase', compact('profile', 'item'));
    }


    // 商品購入画面（購入）
    public function stripeStore(Request $request, Item $item)
    {
        $profile = Profile::find(Auth::id());
        $shipping_address = $profile->postcode . $profile->address . $profile->building;

        DB::beginTransaction();
        $purchase = new Purchase();
        $purchase->fill([
            'profile_id'       => $profile->id,
            'item_id'          => $item->id,
            'purchase'         => 2,
            'shipping_address' => $shipping_address,
        ])->save();
        DB::commit();

        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));
        try {
            \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => $item->price,
                'currency' => 'jpy',
            ]);
        } catch (Exception $e) {
            return back();
        }
        return redirect('/');
    }
}
