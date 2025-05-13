<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Exhibition;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\transaction;
use App\Models\Profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class PurchaseController extends Controller
{
    // 商品購入画面の表示
    public function create(Item $item) {
        $profile = Profile::find(Auth::id());
        return view('purchase', compact('profile', 'item'));
    }

	// 購入処理（stripe）
	public function purchase(PurchaseRequest $request, Item $item)
	{
		$stripe = new StripeClient(config('stripe.stripe_secret_key'));
		[
			$profile_id,
			$amount,
			$payment_method,
			$user_postcode,
			$user_address,
			$user_building
		] = [
			Profile::find(Auth::id())->id,
			$item->price,
			$request->payment_method,
			$request->user_postcode,
			urlencode($request->user_address),
			urlencode($request->user_building) ?? null
		];

		$checkout_session = $stripe->checkout->sessions->create([
			'payment_method_types' => [$request->payment_method],
			'payment_method_options' => [
				'konbini' => [
					'expires_after_days' => 7,
				],
			],
			'line_items' => [
				[
					'price_data' => [
						'currency' => 'jpy',
						'product_data' => ['name' => $item->name],
						'unit_amount' => $item->price,
					],
					'quantity' => 1,
				],
			],
			'mode' => 'payment',
			'success_url' => "http://localhost/purchase/{$item->id}/success?profile_id={$profile_id}&amount={$amount}&payment_method={$payment_method}&user_postcode={$user_postcode}&user_address={$user_address}&user_building={$user_building}",
		]);

		return redirect($checkout_session->url);
	}

	// 購入完了（DBの登録・更新）
	public function success(Request $request, Item $item)
	{
		if (!$request->profile_id || !$request->amount || !$request->payment_method || !$request->user_postcode || !$request->user_address) {
			throw new Exception("You need all Query Parameters (profile_id, amount, payment_method, user_postcode, user_address)");
		}

		$stripe = new StripeClient(config('stripe.stripe_secret_key'));

		$stripe->charges->create([
			'amount'   => $request->amount,
			'currency' => 'jpy',
			'source'   => 'tok_visa',
		]);

		$profile = Profile::find(Auth::id());
		$shipping_address = $profile->user_postcode . $profile->user_address . $profile->user_building;

		Exhibition::find($item->id)->update(['status' => 2]);
		Transaction::where('profile_id', '!=', $profile->id)->where('item_id', $item->id)->first()->update(['status' => 1]);

		Purchase::create([
			'profile_id'       => $profile->id,
			'item_id'          => $item->id,
			'status'           => 1,
			'payment_method'   => $request->payment_method,
			'shipping_address' => $shipping_address,
		]);

		Transaction::create([
			'profile_id' => $profile->id,
			'item_id'    => $item->id,
			'exhibitor'  => 0,
			'purchaser'  => 1,
			'status'     => 1,
		]);

		return redirect('/')->with('flashSuccess', '決済が完了しました！');
	}
}
