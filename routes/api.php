<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
	'namespace' => 'Api',
	'as' => 'api.'
], function() {

	Route::post('/register', 'AuthController@register')->name('register');
	Route::post('/login', 'AuthController@login')->name('login');
	Route::post('/social-register', 'AuthController@registerSocial');

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/recently-viewed-products', 'HomeController@getRecentlyViewedProducts');
	Route::get('/you-may-like-products', 'HomeController@getYouMayLikeProducts');

	Route::get('/about', 'PageController@getAbout')->name('about');
	Route::get('/contact', 'PageController@getContact')->name('contact');
	Route::post('/contact', 'PageController@storeContact');
	Route::get('/policies', 'PageController@getPolicies');
	Route::get('/ads', 'PageController@getAds');
	Route::post('/track-order', 'PageController@trackOrder');

	Route::get('/products', 'ProductController@index')->name('products.index');
	Route::get('/product/{product}', 'ProductController@show')->name('products.show');
	Route::get('/stock-quantity/{id}', 'ProductController@checkStock')->name('check.stock');

	Route::get('/category/{category}/products', 'CategoryController@categoryProducts')->name('category.products');

	Route::get('/search', 'SearchController@searchProducts')->name('search');

	Route::get('/review/{product_id}', 'ReviewController@index')->name('review.index');

	Route::group([
		'middleware' => 'auth:api'
	], function() {

		Route::get('/user-verification', 'AuthController@verifyUser');

		Route::post('/sell-with-us', 'PageController@storeSellWithUs');
		Route::post('/request-product', 'PageController@requestProduct');

		Route::get('/shipping-places', 'CheckoutController@index')->name('checkout.index');
		Route::post( '/checkout', 'CheckoutController@handleCheckout' )->name( 'checkout.store' );
		Route::get( '/checkout/order-received', 'CheckoutController@handleOrderStatus' )->name( 'checkout.order-status' );
		Route::get('/checkout/shipamount', 'CheckoutController@shippingAmount')->name('checkout.ship');
		Route::post('/check-coupon', 'CheckoutController@couponCheck')->name('check.coupon');

		Route::get('/my-account', 'AccountController@index')->name('my-account');
		Route::get('/my-account/default-address', 'AccountController@defaultAddress');
		Route::get('/my-account/orders', 'AccountController@getOrders')->name('my-account.orders');
		Route::get('/my-account/order/{id}/cancel', 'AccountController@cancelOrder')->name('my-account.order.cancel');
		Route::get('/my-account/order/{id}', 'AccountController@viewOrder')->name('my-account.order.view');
		Route::post('/my-account/add-shipping-address', 'AccountController@postShippingStore');
		Route::post( '/my-account/edit-shipping-address/{id}', 'AccountController@updateShippingAddress' );
		Route::delete('/my-account/delete-shipping-address/{id}', 'AccountController@postShippingDelete');
		Route::post( '/my-account/edit-account', 'AccountController@updateAccount' );
		Route::post( '/my-account/change-password', 'AccountController@updatePassword' );
		Route::post('/my-account/edit-personal-info', 'AccountController@postInfoStore');
		Route::get('/my-account/wishlists', 'AccountController@getWishlist')->name('my-account.wishlists');
		Route::post('/my-account/wishlist', 'AccountController@storeWishlist')->name('my-account.wishlist.store');
		Route::get('/my-account/wishlist/{id}', 'AccountController@destroyWishlist')->name('my-account.wishlist.delete');
		Route::get('/user-image', 'AccountController@userImage');
		Route::post('/user-image', 'AccountController@storeImage');
		Route::post('/my-account/use-address', 'AccountController@useAddress');

		Route::post('/review', 'ReviewController@store')->name('review.store');

		Route::get('/product-wishlist/{id}', 'ProductController@checkWishlist')->name('product.wishlist');

		Route::get('/scan-barcode/{order}', 'AccountController@scanBarcode');
		Route::get('/scan-order-number/{number}', 'AccountController@scanOrderNumber');

		Route::get('/notifications', 'NotificationController@index');
		Route::get('/notifications-count', 'NotificationController@notificationsCount');
		Route::get('/mark-all-as-read', 'NotificationController@markAllAsRead');
		Route::get('/mark-as-read/{id}', 'NotificationController@markAsRead');
	});
});
