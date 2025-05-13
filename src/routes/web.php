<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Requests\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 商品一覧画面
Route::get('/', [ItemController::class, 'index'])->name('item.index');

// 商品詳細画面
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');
Route::get('/purchase/item/{item}', [ItemController::class, 'buyItem'])->name('item.buyItem');

// 認証画面
Route::post('/register', [RegisteredUserController::class, 'store'])->name('registeredUser.store');
Route::prefix('login')->group(function () {
	Route::get('/', [LoginController::class, 'create'])->name('login.create');
	Route::post('/', [AuthenticatedSessionController::class, 'store'])->middleware('email')->name('login.store');
});

// メール認証
// 会員登録画面 → メール認証画面
Route::get('/email/verify', function () {
	return view('auth.verify-email');
})->name('verification.notice');

// メール認証画面 → プロフィール設定画面（初回登録）
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
	$request->fulfill();
	session()->forget('unauthenticated_user');
	return redirect('/mypage/profile');
})->name('verification.verify');

// 認証メール再送ボタン押下
Route::post('/email/verification-notification', function (Request $request) {
	session()->get('unauthenticated_user')->sendEmailVerificationNotification();
	session()->put('resent', true);
	return back()->with('message', 'Verification link sent!');
})->name('verification.send');


// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // ログアウト処理
	Route::post('/logout', [LoginController::class, 'destroy'])->name('login.destroy');

	// 商品出品画面
	Route::prefix('sell')->group(function () {
		Route::get('/', [ExhibitionController::class, 'create'])->name('exhibition.create');
		Route::post('/', [ExhibitionController::class, 'store'])->name('exhibition.store');
	});

	Route::prefix('mypage')->group(function () {
		// プロフィール画面
		Route::get('/', [ItemController::class, 'mypage'])->name('item.mypage');

		// 出品商品編集画面
		Route::prefix('sell')->group(function () {
			Route::get('/{item}', [ExhibitionController::class, 'edit'])->name('exhibition.edit');
			Route::put('/{item}', [ExhibitionController::class, 'update'])->name('exhibition.update');
		});

		// 取引チャット画面
		Route::prefix('transaction')->group(function () {
			Route::get('/{tag}/{item}', [TransactionController::class, 'create'])->name('transaction.create');
			Route::post('/{tag}/{item}', [TransactionController::class, 'store'])->name('transaction.store');
			Route::post('/{tag}/{item}/review', [TransactionController::class, 'review'])->name('transaction.review');
			Route::post('/{tag}/{item}/chat', [TransactionController::class, 'message'])->name('transaction.message');
			Route::put('/{tag}/{item}/chat/{message}', [TransactionController::class, 'update'])->name('transaction.update');
			Route::delete('/{tag}/{item}/chat/{message}', [TransactionController::class, 'destroy'])->name('transaction.destroy');
		});

		// プロフィール設定画面（初回登録・編集）
		Route::prefix('profile')->group(function () {
			Route::get('/', [ProfileController::class, 'create'])->name('profile.create');
			Route::post('/', [ProfileController::class, 'store'])->name('profile.store');
			Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
			Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
		});
	});

	Route::prefix('item')->group(function () {
		// いいね機能
		Route::post('/{item}/like', [ItemController::class, 'toggleLike'])->name('item.toggleLike');
		// コメント機能
		Route::post('/{item}/comment', [ItemController::class, 'comment'])->name('item.comment');
	});

	Route::prefix('purchase')->group(function () {
		// 商品購入画面
		Route::get('/{item}', [PurchaseController::class, 'create'])->name('purchase.create');
		Route::post('/{item}', [PurchaseController::class, 'purchase'])->name('purchase.purchase');
		Route::get('/{item}/success', [PurchaseController::class, 'success'])->name('purchase.success');

		// 配送先変更画面
		Route::prefix('address')->group(function () {
			Route::get('/{item}', [ProfileController::class, 'addressEdit'])->name('profile.addressEdit');
			Route::put('/{item}', [ProfileController::class, 'addressUpdate'])->name('profile.addressUpdate');
		});
	});
});