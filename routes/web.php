<?php

Auth::routes();


Route::get( '/autoComplete', 'SearchController@autoComplete' );
Route::get( '/autoCategory', 'SearchController@autoCategory' );


Route::get( 'login/{provider}', 'Auth\LoginController@redirectToProvider' );
Route::get( 'login/{provider}/callback', 'Auth\LoginController@handleProviderCallback' );


//Route::get('/brands/product', 'BrandController@getBrandProducts')->name('brands.product');
Route::post('/referal/check','HomeController@referalCheck')->name('referal.check');
Route::post('/coupon/check','HomeController@couponCheck')->name('coupon.check');
Route::get( '/search', 'SearchController@getSearch' )->name( 'search' );
Route::post('/product/{id}', 'HomeController@ppcGenerate')->name('referlink.generate');

Route::get('/verifyemail/{token}','HomeController@verify');
Route::get('/resend-email/{id}','HomeController@resendMail')->name('resend.mail');

Route::get('sell-with-us', 'Front\HomeController@sellWithUs')->name('sell.index');
Route::get('seller/login', 'Front\HomeController@sellonLogin')->name('seller.login');

Route::get('seller/register', 'Front\HomeController@vendorRegistration')->name('sell.registration');

Route::post('sell/post','Vendor\VendorController@sendVendorRequest')->name('sell.post');


Route::post('complete/post','Vendor\VendorController@completeVendorRegistration')->name('complete.post');

Route::get('/complete_vendor_registration', 'Front\HomeController@completeRegistration')->name('registration.complete')->middleware('auth');



Route::get('/mission-vision', 'PageController@getMission')->name('mission');
Route::get('/payments', 'PageController@getPayments')->name('payments');
Route::get('/about-shipping', 'PageController@getShipping')->name('shipping');
Route::get('/return-policy', 'PageController@getReturnPolicy')->name('return_policy');
Route::get('/privacy-policy', 'PageController@getPrivacyPolicy')->name('privacy_policy');
Route::get('/terms-conditions', 'PageController@getTermsConditions')->name('terms_conditions');
Route::get('/cancellation-refunds', 'PageController@getCancellation')->name('cancellation');

Route::group( [ 'namespace'  => 'Frontend',],    function () {
    
    Route::get('order/payment/conform', 'CheckoutController@paymentConform')->name('order.payment.confirm');
    Route::get('order/payment/verify', 'CheckoutController@paymentVerify')->name('order.payment.verify');

    Route::post('/compare/test', 'CategoryController@test')->name('compare.test');
    Route::get('/compare/{slug1}/{slug2}', 'CategoryController@compare')->name('compare.product');
        
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/about-us', 'HomeController@aboutUs')->name('aboutus');
    Route::get('/vendor-help', 'HomeController@vendorHelp')->name('vendorhelp');

    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/product/{slug}/{token}', 'ProductController@countReferral')->name('payperclick.show');

    Route::get('/product/{slug}', 'ProductController@getProduct')->name('product.show');
    Route::post('/product', 'ProductController@storeNotifyInstockEmail')->name('notify.stock');
    Route::get('/negoitable/products','NegProductController@getNegProducts')->name('negoitable.products');


    Route::get( '/category/{slug}', 'CategoryController@getCategoryProducts' )->name( 'category' );
    
    Route::get( '/vendor/{slug}', 'CategoryController@getVendorProducts' )->name( 'vendor.product' );
//  Route::post( '/category/{slug}', 'CategoryController@filter' )->name( 'filter' );

    Route::get( '/brand/{slug}', 'BrandController@getBrandProducts' )->name( 'brand' );
    Route::get('/deal/{slug}', 'BrandController@getDealProducts')->name('deal');

    //cart
    Route::post( '/cart', 'CartController@store' )->name( 'cart.store' );
    Route::post( '/buy-now.', 'CartController@buyNow' )->name( 'cart.buy' );
    Route::post( '/buy-prebooking-item.', 'CartController@buyPrebookingItem' )->name( 'cart.prebooking' );
    Route::get( '/cart', 'CartController@index' )->name( 'cart' );
    Route::post( '/cart/destroy/{rowId}', 'CartController@destroy' )->name( 'cart.destroy' );
    Route::get( '/mini-cart', 'CartController@getMiniCart' )->name('cart.mini' );
    Route::get( '/mobile-cart', 'CartController@getMobileCart' )->name( 'cart.mobile' );
    Route::post( '/cart/update', 'CartController@update' )->name( 'cart.update' );
    Route::post('wishlist/store','WishListController@store')->name('wishlist.store');

    Route::get( '/wishlist-cart', 'WishlistController@getMiniwishlist' )->name('wishlist.mini');
    Route::get( '/wishlist-home-remove', 'WishlistController@gethomeremove' )->name( 'wishlist.home.remove' );
    Route::post('wishlist/remove','WishListController@delete')->name('wishlist.remove');


    //Coupon
    Route::post('/coupon', 'HomeController@matchCoupon')->name('coupon.match');

    //Quick View
    Route::get('/quickview/{id}', 'HomeController@quickView')->name('quick.view');

        
});

Route::get('/contact-us/create','ContactController@getCreate')->name('contact.create');
Route::post('/contact-us/create','ContactController@getStore')->name('contact.store');
Route::get('/contact-us/view/{id}', 'ContactController@getView')->name('contact.edit');
Route::get('/contact-us/send/{id}', 'ContactController@sendEmail')->name('contact.send');
Route::delete('/contact-us/delete/{id}', 'ContactController@deleteMessage')->name('delete.contact.message');
Route::put('/contact-us/all-read', 'ContactController@makeAllRead')->name('make-all-read');
Route::get('/contact-us/','ContactController@getIndex')->name('contact');
Route::get('/contact-us/json','ContactController@getContactsJson')->name('admin.contact.json');


Route::group( ['middleware' => 'auth','namespace' => 'Frontend'], function () {
    Route::post('/review/post', 'ReviewProductController@postReview')->name('review.post');
    Route::post('/vendor/review/post', 'ReviewProductController@vendorReview')->name('vendor.review');
    // User Account
    Route::get('/negotiable/create/{product_id}','NegotiableController@create')->name('negotiable.create');
    Route::get('/user/account', 'ShippingAccountController@getIndex')->name('user.account');
    
    Route::post('trac-no','HomeController@checkTrack')->name('track_no');
    Route::get('track/order', 'HomeController@getTrack')->name('track.order');


    Route::post('/user/account/edit', 'ShippingAccountController@postUserStore')->name('my-account.user.create');
    Route::post('/user/profile/edit', 'ShippingAccountController@postInfoStore')->name('my-account.user-info.create');
    Route::post('/user/shipping/create', 'ShippingAccountController@postShippingStore')->name('my-account.shipping.create');
    Route::get('/user/shipping/delete/{id}', 'ShippingAccountController@postShippingDelete')->name('my-account.shipping.delete');
    Route::get('/user/shipping/edit/{id}', 'ShippingAccountController@postShippingEdit')->name('my-account.shipping.edit');
    Route::post('/user/shipping/update/{id}', 'ShippingAccountController@updateShipping')->name('my-account.shipping.update');
    Route::post('/user/shipping/used', 'ShippingAccountController@useAddress')->name('my-account.shipping.use');
    // Route::post('/user/shipping/main', 'ShippingAccountController@postShippingUpdate')->name('my-account.shipping.main');
    Route::get( '/user/order/cancel/{id}', 'ShippingAccountController@cancelOrder' )->name( 'my-account.order.cancel' );
    Route::get('/user/order-details/{id}', 'ShippingAccountController@viewOrderDetails')->name('my-account.order-details');
    Route::post('/user/account-info/store', 'ShippingAccountController@accountInfoStore')->name('my-account.info.store');

    //Negoiate
     Route::get('/negotiable/{id}', 'NegotiableController@index')->name('negotiate.chat');
     Route::get('/negotiable/delete/{id}', 'NegotiableController@destroy')->name('negotiate.delete');
     Route::post('/negotiable/{id}', 'NegotiableController@store')->name('negotiable.store');
     Route::get('/negotiable/reload', 'NegotiableController@reload')->name('negotiable.reload');
     Route::get('negoiate/checkout/{id}','NegotiableController@checkout')->name('negoiate.checkout');
    
    // request_products
    Route::get('/request-product','RequestProductController@getIndex');
    Route::get('/request-product/create','RequestProductController@getCreate')->name('request.product.create');
    Route::post('/request-product/store','RequestProductController@postStore')->name('request.product');
    Route::delete('/request-product/{id}','RequestProductController@deleteRequestProduct')->name('admin.request.product.delete');

    // Checkout
    Route::get('/checkout', 'CheckoutController@index')->name('checkout');
    Route::post('/checkout', 'CheckoutController@handleCheckout')->name('checkout.store');
    Route::post('/checkout/{id}', 'CheckoutController@update')->name('checkout.update');
    Route::get('/checkout/order-received', 'CheckoutController@handleOrderStatus' )->name( 'checkout.order-status' );
    Route::get('/checkout/shipamount/', 'CheckoutController@shippingAmount')->name('checkout.ship');
        Route::get('/checkout/zone/', 'CheckoutController@zonechange')->name('checkout.zone');
    Route::get('/checkout/duplicate_product/', 'CheckoutController@checkOrderProductDuplicate')->name('checkout.duplicate_product');


    
    //wishlist

    Route::get('/wishlist/my-wishlist','ShippingAccountController@myWishlist')->name('wishlist.mywishlist');

    Route::get('/wishlist/create/{product_id}', 'ShippingAccountController@wishlist')->name('wishlist.create');
    Route::get('/wishlist/delete/{id}', 'ShippingAccountController@wishlistDestory')->name('wishlist.delete');


    //disputes
    Route::get('/disputes/{id}', 'DisputeController@index')->name('user.disputes');
    Route::post('/disputes/save', 'DisputeController@save')->name('dispute.message.save');
    Route::post('/disputes/{id}', 'DisputeController@storeDisputes')->name('disputes.store');

    // Order Return
    Route::get('/order_return/{id}', 'OrderController@index')->name('order.return');
    Route::post('/order_return/store', 'OrderController@store')->name('order_return.message.store');
    //Sell

});

Route::group( [ 'middleware' => 'auth' ], function () {
        Route::group( ['prefix' => 'admin', 'as' =>'admin.','namespace'  => 'Backend', 'middleware' => 'role:admin|logistics|customer_care|content-writer|digital_marketing'],function () {

  // Users
    Route::get( '/users/admin', 'UserController@getAdminUsersJson' )->name( 'users.admin.json' );
    Route::get( '/users/manager', 'UserController@getManagerUsersJson' )->name( 'users.manager.json' );
    Route::get( '/users/client', 'UserController@getClientUsersJson' )->name( 'users.client.json' );
    Route::get('/users/create', 'UserController@create')->name('users.create');
    Route::get( '/users', 'UserController@main' )->name('users.main');
    Route::post('/users/store', 'UserController@store')->name('users.store');
    Route::get('/users/edit/{id}', 'UserController@edit')->name('users.edit');
    Route::get('/users/show/{id}', 'UserController@show')->name('users.show');
    Route::patch('/users/update/{id}', 'UserController@update')->name('users.update');
    Route::get('/users/delete/{id}', 'UserController@destroy')->name('users.destroy');
    Route::get( '/get-users', 'UserController@getUsersJson' )->name( 'users.json' );


    Route::get('category/delete/{id}', 'CategoryController@destroy')->name('category.delete');

    Route::get('/products/delete/{id}', 'ProductController@delete')->name('products.delete');
            Route::get('/brands/delete/{id}', 'BrandController@delete')->name('brands.delete');

});
    Route::group( ['prefix' => 'admin', 'as' =>'admin.','namespace'  => 'Backend', 'middleware' => 'role:admin|logistics|customer_care|content_writer|digital_marketing|graphic'],function () {
//Dashboard
    Route::get('/', 'DashboardController@index')->name('index');
    
    
    Route::get('/csreport', 'OrderController@csReport')->name('cs.report');
        Route::get('/csreport/order', 'OrderController@csReportOrder')->name('cs.report.order');
    
    //Ads
    Route::get('/ads','DashboardController@getAds')->name('ads.all');
    Route::get('/ads/edit/{id}','DashboardController@getEdit')->name('ads.edit');
    Route::post('/ads/update/{id}','DashboardController@editAds')->name('ads.update');


//review
    Route::get('/reviews', 'ReviewController@index')->name('reviews.index');
    Route::get('/reviews/json', 'ReviewController@getReviewJson')->name('review.json');
    Route::post( '/review/status/{id}', 'ReviewController@updateStatus' )->name( 'review.status' );

    Route::get('/review/delete/{id}', 'ReviewController@destroy')->name('review.delete');

//Pgaes
    Route::resource( 'page', 'PageController', [ 'except' => [ 'show' ] ] );
    Route::get( '/get-pages', 'PageController@getPagesJson' )->name( 'pages.json' );
        //Vendor Request
    Route::get('vendor/request','VendorRequestController@index')->name('vendor.request');
    Route::post('vendor/accept','VendorRequestController@accept')->name('vendor.accept');
    Route::post('vendor/reject','VendorRequestController@reject')->name('vendor.reject');
    Route::post('vendor/delete','VendorRequestController@delete')->name('request.delete');
    Route::get('vendor/request/view/{id}','VendorRequestController@view')->name('request.view');

//        payment

    Route::get('/paymentmethod', 'PaymentMethodController@index')->name('payment.index');
    Route::post('/paymentmethod/Store', 'PaymentMethodController@store')->name('payment.store');
    Route::get('/paymentmethod/delete/{id}', 'PaymentMethodController@destory')->name('payment.delete');
    Route::get('/paymentmethod/edit/{id}', 'PaymentMethodController@edit')->name('payment.edit');
    Route::post('/paymentmethod/update', 'PaymentMethodController@update')->name('payment.update');


 //Delivery Destination
    Route::get('/delivery/destination', 'DeliveryDestinationController@index')->name('delivery.index');
    Route::post('/delivery/destination/Store', 'DeliveryDestinationController@store')->name('delivery.store');
    Route::get('/delivery/destination/delete/{id}', 'DeliveryDestinationController@destory')->name('delivery.delete');
    Route::get('/delivery/destination/edit/{id}', 'DeliveryDestinationController@edit')->name('delivery.edit');
    Route::post('/delivery/destination/update', 'DeliveryDestinationController@update')->name('delivery.update');


 //vendor Review
    Route::get('/vendor/reviews', 'VendorReviewController@index')->name('vendor.reviews.index');
    Route::get('/vendor/reviews/json', 'VendorReviewController@getReviewJson')->name('vendor.review.json');
    Route::post( '/vendor/review/status/{id}', 'VendorReviewController@updateStatus' )->name( 'vendor.review.status' );

    Route::get('/vendor/review/delete/{id}', 'VendorReviewController@destroy')->name('vendor.review.delete');
//Category
    Route::get('category', 'CategoryController@index')->name('category');
    Route::get('category/add', 'CategoryController@create')->name('category.add');
    Route::post('category/store', 'CategoryController@store')->name('category.store');
    Route::get('category/edit/{id}', 'CategoryController@edit')->name('category.edit');
    Route::post('category/update', 'CategoryController@update')->name('category.update');
    Route::get('category/json', 'CategoryController@getCategoryJson')->name('category.json');
    //Menu
    Route::get('/menu', 'MenuController@index')->name('menu.index');
    Route::get('/menu/view', 'MenuController@show')->name('menu.show');
    Route::post( '/menu/addmenu', 'MenuController@addmenu' )->name( 'haddmenu' );
    //Settings
    Route::get('front/ads/create','ConfigurationController@getAdsCreate')->name('front.ads.create');
    Route::post('front/ads/delete/','ConfigurationController@removeAds')->name('front.ads.delete');
    Route::get('/settings', 'ConfigurationController@getConfiguration')->name('settings');
    Route::post('/settings', 'ConfigurationController@postConfiguration')->name('settings.update');
    // Home
    Route::get('/home_section', 'HomeController@getHome')->name('home');
    Route::post('/home_section', 'HomeController@postHome')->name('home.update');
    
    //    sales report
        Route::get('/sales_report', 'SaleReportController@index')->name('sales-report');
        Route::get('/sales_report/excel', 'SaleReportController@getExcel')->name('sales-report.excel');
        Route::get('/sales_report/json', 'SaleReportController@salesReportJson')->name('sales-report.json');
        Route::post('/sales_report/filter/', 'SaleReportController@getReport')->name('sales-report.filter');
    
    //Teams
    Route::get('/teams', 'TeamController@index')->name('teams.index');
    Route::get('/team/create', 'TeamController@create')->name('teams.create');
    Route::post('/team/store', 'TeamController@store')->name('team.store');
    Route::get('/team/edit/{id}', 'TeamController@edit')->name('team.edit');
    Route::post('/team/update/{id}', 'TeamController@update')->name('team.update');
    Route::post('/team/delete/{id}', 'TeamController@delete')->name('team.delete');
    Route::get('/teams/json', 'TeamController@getTeamJson')->name('teams.json');


//SlideShow
    Route::get('/slideshows', 'SlideshowController@index')->name('slideshow.index');
    Route::post('slideshow/store', 'SlideshowController@store')->name('slideshow.store');
    Route::get('/slideshow/json', 'SlideshowController@getSlideshowJson')->name('slideshow.json');
    Route::get('/slideshow/delete/{id}', 'SlideshowController@delete')->name('slideshow.delete');
    Route::get('/slideshow/edit/{id}', 'SlideshowController@editSlideshow')->name('slideshow.edit');
    Route::get('/slideshow/create', 'SlideshowController@create')->name('slideshow.create');
    Route::post('/slideshow/update/{id}', 'SlideshowController@update')->name('slideshow.update');


//Forum
    Route::get('questions', 'Forumcontroller@index')->name('question.index');
    Route::post('question/store', 'ForumController@create')->name('question.store');
    Route::post('answer/store/{id}', 'AnswerController@answerStore')->name('answer.store');
    Route::get('/like/{id}/{value}', 'ForumController@like')->name('like');
    Route::get('/question/add', 'ForumController@index')->name('question.add');
    Route::get('/question/{id}', 'ForumController@getForum')->name('question');

//Testimional
    Route::get('/testimonials', 'TestimonialController@index')->name('testimonials.index');
    Route::get('/testimonials/create', 'TestimonialController@create')->name('testimonials.create');
    Route::post('/testimonials/store', 'TestimonialController@store')->name('testimonials.store');
    Route::get('/testimonials/json', 'TestimonialController@getTestimonialsJson')->name('testimonials.json');
    Route::get('/testimonials/edit/{id}', 'TestimonialController@edit')->name('testimonials.edit');
    Route::post('/testimonials/update/{id}', 'TestimonialController@update')->name('testimonials.update');
    Route::get('/testimonials/delete/{id}', 'TestimonialController@delete')->name('testimonials.delete');

        // Deals
        Route::get('/deals', 'DealController@index')->name('deals.index');
        Route::get('/deals/create', 'DealController@create')->name('deals.create');
        Route::post('/deals/store', 'DealController@store')->name('deals.store');
        Route::get('/deals/edit/{id}', 'DealController@edit')->name('deals.edit');
        Route::post('/deals/update', 'DealController@update')->name('deals.update');
        Route::get('/deals/delete/{id}', 'DealController@destroy')->name('deals.delete');
        Route::get('/deals/json', 'DealController@getDealsJson')->name('deals.json');
        Route::get('/deal-product/{id}', 'DealController@dealProduct')->name('deals.deal-product');
        Route::get('/deal-product-add/json', 'DealController@getDealProductAddJson')->name('deals.deal-product-add.json');
        Route::post('/deal-product/store', 'DealController@dealProductStore')->name('deal-product.store');
        Route::get('/deal-product/json/{id}', 'DealController@getDealProductJson')->name('deal-product.json');
        Route::get('/deal-product/delete/{id}', 'DealController@deleteDealProduct')->name('deal-product.delete');

  

    //Vendor
    Route::get('/details', 'UserController@index')->name('vendors.details');
    Route::get('/details/delete/{id}', 'UserController@delete')->name('vendors_details.delete');
    Route::get('/details/edit/{id}', 'UserController@editVendorDetails')->name('vendors_details.edit');
    Route::post('/details/update', 'UserController@updateVendorDetails')->name('vendors_details.update');
    Route::get('/json', 'UserController@getVendorDetails')->name('vendors.json');
    Route::post('/details/store', 'UserController@storeVendorDetails')->name('vendors_details.store');
    Route::get('/details/view/{id}', 'UserController@viewVendorDetails')->name('vendors_details.view');
    Route::get('/vendors', 'UserController@getVendors')->name('vendor.index');
    Route::get('/vendors/json', 'UserController@getVendorsJson')->name('vendor.json');
    Route::get('/vendor/stats/{id}', 'UserController@getVendorStats')->name('vendor.stat');
    Route::get('/vendor/stats/json/{id}', 'UserController@getVendorStatsJson')->name('vendor.stat.json');
    Route::get('/vendor/stats/details/{id}', 'UserController@getVendorTable')->name('vendor.stat.details');

    Route::get('/product/{id}', 'ProductController@singleProduct')->name('singleProduct');


    //Disputes
    Route::get('/disputes', 'DisputeController@index')->name('disputes');
    Route::post('/disputes/status-update/{id}', 'DisputeController@statusUpdate')->name('disputes.status_update');
    Route::get('/disputes/details/{id}', 'DisputeController@viewDetails')->name('disputes.view_details');
    Route::post('/dispute/result', 'DisputeController@resultStore')->name('dispute.result_store');
    Route::get('/reload', 'DisputeController@reload')->name('message.reload');
    Route::post('/disputes/store/{id}', 'DisputeController@storeDisputes')->name('disputes.store');

    //Chat
    Route::get('/chat/{id}', 'UserController@chat')->name('chat');
    Route::post('/chat/vendor/store', 'UserController@chatStore')->name('chat.vendor.store');

    //Coupons
    Route::get('/coupon', 'CouponController@index')->name('coupon.index');
    Route::get('/coupon/create', 'CouponController@create')->name('coupon.create');
    Route::post('/coupon/store', 'CouponController@store')->name('coupon.store');
    Route::get('/coupon/edit/{id}', 'CouponController@edit')->name('coupon.edit');
    Route::post('/coupon/update', 'CouponController@update')->name('coupon.update');
    Route::get('/coupon/delete/{id}', 'CouponController@destroy')->name('coupon.delete');

    //Commissions
    Route::get('/commissions', 'CommissionController@index')->name('commissions.index');
    Route::get('/commission/create/{id}', 'CommissionController@create')->name('commission.create');
    Route::post('/commission/store', 'CommissionController@store')->name('commission.store');
    Route::get('/commission/edit/{id}', 'CommissionController@edit')->name('commission.edit');
    Route::post('/commission/update', 'CommissionController@update')->name('commission.update');
    Route::get('/commission/delete/{id}', 'CommissionController@destroy')->name('commission.delete');

    // Area
    Route::delete('/area/{id}','MultiController@destroyArea')->name('area.destroy');
    Route::put('/area/{id}','MultiController@updateArea')->name('area.update');
    Route::get('/area/edit/{id}','MultiController@getEditArea')->name('area.edit');
    Route::post('/area/create','MultiController@postStoreArea')->name('area.store');
    Route::get('/area/create','MultiController@getCreateArea')->name('area.create');
    Route::get('/area','MultiController@getArea')->name('area.index');
    // Package
    Route::delete('/package/{id}','MultiController@destroyPackage')->name('package.destroy');
    Route::put('/package/{id}','MultiController@updatePackage')->name('package.update');
    Route::get('/package/edit/{id}','MultiController@getEditPackage')->name('package.edit');
    Route::post('/package/create','MultiController@postStorePackage')->name('package.store');
    Route::get('/package/create','MultiController@getCreatePackage')->name('package.create');
    Route::get('/package','MultiController@getPackage')->name('package.index');
    // Type
    Route::delete('/type/{id}','MultiController@destroyType')->name('type.destroy');
    Route::put('/type/{id}','MultiController@updateType')->name('type.update');
    Route::get('/type/edit/{id}','MultiController@getEditType')->name('type.edit');
    Route::post('/type/store','MultiController@postStoreType')->name('type.store');
    Route::get('/type/create','MultiController@getCreateType')->name('type.create');
    Route::get('/type','MultiController@getType')->name('type.index');

    // Orders
    Route::get( '/search-user', 'UserController@searchUser' )->name( 'search.user' );
    Route::get( '/search-product', 'ProductController@searchProduct' )->name( 'search.product' );

    Route::get( '/order/add-product', 'OrderController@addProduct' )->name( 'order.add.product' );
    Route::get( '/order/update-product', 'OrderController@updateProduct' )->name( 'order.update-product' );
    Route::get( '/order/update-product-summary', 'OrderController@updateProductSummary' )->name( 'order.update-product-summary' );
    Route::get( '/order/update-user-address', 'OrderController@updateUserAddress' )->name( 'order.update-user-address' );
    Route::get( '/order/{order}/invoice', 'OrderController@generateInvoice' )->name( 'order.invoice' );
    Route::get( '/order/vendor/{order}/invoice', 'OrderController@generateVendorInvoice' )->name( 'order.vendor.invoice' );
            Route::get( '/order/product/{order}/return', 'OrderController@orderProductReturn' )->name( 'order.product.return' );

        Route::get( '/order_return/vendor/{order}/invoice', 'OrderController@generateVendorReturnInvoice' )->name( 'order_return.vendor.invoice' );

    Route::get( '/order/{order}/pre-invoice', 'OrderController@generatePreInvoice' )->name( 'order.pre_invoice' );
    Route::resource( 'order', 'OrderController', [ 'except' => [ 'show' ] ] );
    Route::get('/order/generate-barcode/{id}', 'OrderController@generateBarcode')->name('order.barcode');
    Route::get('/order/bulk/generate-barcode/', 'OrderController@generateBulkBarcode')->name('order.bulk.barcode');
  Route::get('/orders/export-excel/status/{status}', 'OrderController@exportToExcel')->name('export.excel');
    Route::get('/orders/export-excel/selected/{status}', 'OrderController@exportSelectedToExcel')->name('export.selected');
        Route::get('/orders/change/status/{status}', 'OrderController@bulkStatus')->name('order.bulk.status');
        Route::get( '/orders/bulk/invoice', 'OrderController@generateBulkInvoice' )->name( 'order.bulk.invoice' );
        Route::get( '/order/list', 'OrderController@orderList' )->name( 'order.list' );



    Route::get( '/orders/json/{status}', 'OrderController@getOrdersJson' )->name( 'orders.json' );
    Route::get('/order_return', 'OrderController@getOrderReturns')->name('order.return');
    Route::get( '/order_return/json', 'OrderController@getOrderReturnJson' )->name( 'order_return.json' );
    Route::get('/order_return/edit/{id}', 'OrderController@editOrderReturn')->name('order_return.edit');
    Route::patch('/order_return/update', 'OrderController@updateOrderReturn')->name('order_return.update');
    Route::get('/order_return/delete/{id}', 'OrderController@destroyOrderReturn')->name('order_return.delete');

    //Referals
    Route::get('/referals', 'ReferalController@index')->name('referals.index');
    Route::get('/referal/delete/{id}', 'ReferalController@destroy')->name('referal.delete');
    Route::get('/referals/json', 'ReferalController@getReferalJson')->name('referal.json');

    //Products
    Route::get('/products', 'ProductController@index')->name('products.index');
    Route::get('/products/json/{status}', 'ProductController@getProductsJson')->name('products.json');
    Route::get('/products/create-existing', 'ProductController@getProductCreate')->name('products.create');
    Route::get('/products/create', 'ProductController@create')->name('products.create.new');
    Route::post('/products/existing', 'ProductController@createExistingProduct')->name('existing.product');
    Route::post('/products/store', 'ProductController@store')->name('products.store');
    Route::get('/products/edit/{id}', 'ProductController@edit')->name('products.edit');
    Route::post( '/product/image/upload', 'ProductController@uploadImage' )->name( 'product.image.upload-image' );
    Route::post( '/product/image/delete', 'ProductController@deleteImage' )->name( 'product.image.delete-image' );
    Route::get('/products2/json', 'ProductController@getProductsJson2')->name('products2.json');
    Route::post('/products/update', 'ProductController@update')->name('products.update');
    Route::get('/products/table', 'ProductController@table')->name('products.table');
    Route::get('/products/stock', 'ProductController@stock')->name('products.stock');
    Route::get('/products/updatestatus/{id}', 'ProductController@updateStatus')->name('products.update-status');
    Route::post( '/product/image/delete', 'ProductController@deleteImage' )->name( 'product.image.delete-image' );
    Route::post( '/product/faq/delete', 'ProductController@deleteFaq' )->name( 'product.faq.delete' );
    Route::post( '/product/specification/delete', 'ProductController@deleteSpecification' )->name( 'product.specification.delete' );
    Route::post( '/product/feature/delete', 'ProductController@deleteFeature' )->name( 'product.feature.delete' );
    Route::post( '/product/color/delete', 'ProductController@deleteColor' )->name( 'product.color.delete' );

        //withdraw
    Route::get('/withdraw', 'WithDrawController@getIndex')->name('withdraw');
    Route::get('/withdraw/edit/{id}', 'WithDrawController@getEdit')->name('withdraw.edit');
    Route::post('/withdraw/status/{id}', 'WithDrawController@getChangeStatus')->name('withdraw.status');
    Route::post('/withdraw/verify/{id}', 'WithDrawController@verifyUpdate')->name('withdraw.verify');
    Route::get('/withdraw/cancel/{id}','WithDrawController@getWithdrawCancel')->name('withdraw.cancel');
    
    //Shipping Amount
 //Shipping Amount
    Route::get('/shipping_amount', 'DeliveryController@index')->name('shipping_amount');
    Route::get('/shipping_amount/create', 'DeliveryController@create')->name('shipping_amount.create');
    Route::post('/shipping_amount/store', 'DeliveryController@store')->name('shipping_amount.store');
    Route::get('/shipping_amount/edit/{id}', 'DeliveryController@edit')->name('shipping_amount.edit');
    Route::post('/shipping_amount/update', 'DeliveryController@update')->name('shipping_amount.update');
    Route::get('/shipping_amount/delete/{id}', 'DeliveryController@destroy')->name('shipping_amount.destroy');
    Route::get('/shipping_amount/json', 'DeliveryController@getShippingAmountJson')->name('shipping_amount.json');
        
        //Vendor Stat
            Route::get('/vendor/configuration/{id}', 'VendorStatController@getConfiguration')->name('vendor.configuration');
            Route::post('/vendor/configuration/{id}', 'VendorStatController@saveDetails')->name('vendor.save.details');

    Route::get('/products/{name}/{id}', 'VendorStatController@index')->name('vendor.product_stat.index');
    Route::get('/products_stat/json/', 'VendorStatController@getCustomProductsJson')->name('vendor.product_stat.json');

    Route::get('/orders/{name}/{id}', 'VendorStatController@getOrderStat')->name('vendor.order_stat');
    Route::get('/orders_stat/json/', 'VendorStatController@getOrderStatJson')->name('vendor.order_stat.json');

    Route::get('/order_returns/{name}/{id}', 'VendorStatController@getOrderReturnStat')->name('vendor.order_return_stat');
    Route::get('/order_returns_stat/json/', 'VendorStatController@getOrderReturnStatJson')->name('vendor.order_return_stat.json');

    //negoiate
     Route::get('/negotiate', 'NegotiableController@index')->name('negotiate');

    Route::get('/negotiable/{id}', 'NegotiableController@show')->name('negotiable.details');

    Route::post('/negotiable/{id}', 'NegotiableController@store')->name('negotiable.store');

    // Request Products
    Route::get('/request-products', 'RequestProductController@index')->name('request_product');
    Route::get('/request-product/{id}/edit', 'RequestProductController@edit')->name('request_product.edit');
    Route::post('/request-product/update/{id}', 'RequestProductController@update')->name('request_product.update');
    Route::get('/request-product/{id}', 'RequestProductController@destroy')->name('request_product.delete');
    Route::get('/request-products/json', 'RequestProductController@getRequestProductJson')->name('request_product.json'); 

    // Seos
    Route::resource('/seo', 'SeoController');
    Route::get('/seo-json', 'SeoController@getSeoJson')->name('seo.json');

    });
    Route::group(['prefix'=>'vendors','as'=>'vendor.','namespace' => 'Vendor','middleware'=>'role:vendor|admin'],function () {
        Route::get('/products/delete/{id}', 'ProductController@delete')->name('products.delete');
        Route::get('/products/edit/{id}', 'ProductController@edit')->name('products.edit');
        Route::post( '/product/image/upload', 'ProductController@uploadImage' )->name( 'product.image.upload-image' );
        Route::post( '/product/image/delete', 'ProductController@deleteImage' )->name( 'product.image.delete-image' );
        Route::get('/products2/json', 'ProductController@getProductsJson2')->name('products2.json');
        Route::post('/products/update', 'ProductController@update')->name('products.update');
        Route::get('/products/table', 'ProductController@table')->name('products.table');
        Route::get('/products/stock', 'ProductController@stock')->name('products.stock'); 
        
        Route::get( '/product/status/update/{id}', 'ProductController@statusUpdate' )->name( 'product.status.update' );
});
        
    Route::group(['prefix'=>'admin','as'=>'admin.','namespace'=>'Backend','middleware'=>'role:vendor|admin'],function () {
  
        //Brands
        Route::post('/brands/store', 'BrandController@store')->name('brands.store');
        Route::get('/brands', 'BrandController@index')->name('brands.index');
        Route::get('/brands/edit/{id}', 'BrandController@editBrand')->name('brands.edit');
        Route::post('/brands/update', 'BrandController@updateBrand')->name('brands.update');
        Route::get('/brandjson', 'BrandController@getBrandsJson')->name('brands.json');
});

    Route::group(['prefix'=> 'vendors','as'=>'vendor.','namespace'=>'Vendor','middleware' => 'role:vendor'],function () {
        // Dashboard
        Route::get('/','VendorController@getDashboard')->name('dashboard');

        Route::get('/product/{name}', 'DashboardController@getProducts')->name('dashboard.index');
        Route::get('/products_stat/json/', 'DashboardController@getProductsJson')->name('dashboard.json');

        Route::get('/order/{name}', 'DashboardController@getOrderStat')->name('order_stat');
        Route::get('/orders_stat/json/', 'DashboardController@getOrderStatJson')->name('order_stat.json');

        Route::get('/order_returns/{name}', 'DashboardController@getOrderReturnStat')->name('order_return_stat');
        Route::get('/order_returns_stat/json/', 'DashboardController@getOrderReturnStatJson')->name('order_return_stat.json');

        // Bank
        Route::get('/bank/account','DashboardController@getBankInfo')->name('bank');

        //Product
        Route::get('/products/create-existing', 'ProductController@getProductCreate')->name('products.create');
        Route::get('/products/create', 'ProductController@create')->name('products.create.new');
        Route::post('/products/existing', 'ProductController@createExistingProduct')->name('existing.product');
        Route::get('/products/json/{status}', 'ProductController@getProductsJson')->name('products.json');
        Route::post('/products/new/store', 'ProductController@storeproduct')->name('products.store.new');
        Route::post( '/product/faq/delete', 'ProductController@deleteFaq' )->name( 'product.faq.delete' );
        Route::post( '/product/specification/delete', 'ProductController@deleteSpecification' )->name( 'product.specification.delete' );
        Route::post( '/product/feature/delete', 'ProductController@deleteFeature' )->name( 'product.feature.delete' );
        Route::post( '/product/color/delete', 'ProductController@deleteColor' )->name( 'product.color.delete' );
        
        //Brands
        Route::post('/brand/store', 'BrandController@store')->name('brands.store');
        Route::get('/brand', 'BrandController@index')->name('brands.index');
        Route::get('/brand/delete/{id}', 'BrandController@delete')->name('brands.delete');
        Route::get('/brand/edit/{id}', 'BrandController@editBrand')->name('brands.edit');
        Route::post('/brand/update', 'BrandController@updateBrand')->name('brands.update');
        Route::get('/brandsjson', 'BrandController@getBrandsJson')->name('brands.json');

        //review

        Route::get('/reviews', 'ReviewController@index')->name('reviews.index');
        Route::get('/reviews/json', 'ReviewController@getReviewJson')->name('review.json');
        Route::post( '/review/status/{id}', 'ReviewController@updateStatus' )->name( 'review.status' );
        Route::get('/ratings', 'ReviewController@vendorRating')->name('vendor.reviews.index');
        Route::get('/vendor/reviews/json', 'ReviewController@getVendorReviewJson')->name('rating.json');

        // Advertise
        Route::post('/advertise/create','AdvertiseController@postStore')->name('advertise.store');
        Route::get('/advertise/create','AdvertiseController@getCreate')->name('advertise.create');
        Route::get('/advertise','AdvertiseController@getIndex')->name('advertise.index');
        Route::get('/advertise/edit/{id}', 'AdvertiseController@edit')->name('advertise.edit');
        Route::put('/advertise/update/{id}', 'AdvertiseController@update')->name('advertise.update');

        // configuration
        Route::get('/configuration','VendorController@getConfiguration')->name('config');
        Route::get('/configuration/{id}','VendorController@getConfigurationEdit')->name('config.edit');
        // order
        Route::get('/order/create','VendorController@getOrderCreate')->name('order.create');
        Route::get('/order','VendorController@getOrder')->name('order');


        //Vendor
        Route::get('/details', 'VendorController@index')->name('vendors.details');
        Route::get('/details/delete/{id}', 'VendorController@delete')->name('vendors_details.delete');
        Route::get('/details/edit/{id}', 'VendorController@editVendorDetails')->name('vendors_details.edit');
        Route::post('/details/update', 'VendorController@updateVendorDetails')->name('vendors_details.update');
        Route::get('/json', 'VendorController@getVendorDetails')->name('vendors.json');
        Route::post('/details/store', 'VendorController@storeVendorDetails')->name('vendors_details.store');
        Route::get('/details/view/{id}', 'VendorController@viewVendorDetails')->name('vendors_details.view');
        Route::post('/details/profile/update', 'VendorController@updateVendorprofile')->name('vendors_details.profile.update');

        Route::get('/profile/{id}', 'VendorController@getVendorProfile')->name('profile');

        //Withdraw
        Route::get('/withdraw','VendorController@getWithdraw')->name('withdraw');
        Route::get('/withdraw/request','VendorController@getWithdrawRequest')->name('withdraw.request');

        Route::get('/withdraw/account','VendorController@getWithdrawAccount')->name('withdraw.account');
        Route::post('/withdraw/store','VendorController@getWithdrawStore')->name('withdraw.store');
        Route::get('/withdraw/cancel/{id}','VendorController@getWithdrawCancel')->name('withdraw.cancel');
        Route::get('/withdraw/use/{id}','VendorController@getWithdrawUse')->name('withdraw.use');

        Route::get('/withdraw/edit/{id}', 'VendorController@getEdit')->name('withdraw.edit');
    //Disputes
        Route::get('/disputes', 'DisputeController@index')->name('disputes');
        Route::get('/disputes/{id}', 'DisputeController@show')->name('disputes.view');
        Route::post('/disputes/{id}', 'DisputeController@storeDisputes')->name('disputes.store');

    //Chat
        Route::get('/chat', 'DisputeController@chat')->name('chat');
        Route::post('/chat/store', 'DisputeController@chatStore')->name('chat.store');

        //Order
         Route::get('/orders/', 'OrderController@index')->name('order.index');
        Route::get( '/orders/json/{status}', 'OrderController@getOrdersJson' )->name( 'orders.json' );
        Route::get('/order_return', 'OrderController@getOrderReturns')->name('order.return');
        Route::get( '/order_return/json', 'OrderController@getOrderReturnJson' )->name( 'order_return.json' );
        Route::get('/order_return/edit/{id}', 'OrderController@editOrderReturn')->name('order_return.edit');
        Route::patch('/order_return/update', 'OrderController@updateOrderReturn')->name('order_return.update');
        
        //negoiate
        Route::get('/negotiate', 'NegotiableController@index')->name('negotiate');

        Route::get('/negotiable/{id}', 'NegotiableController@show')->name('negotiate.vendor');

        Route::post('/negotiable/{id}', 'NegotiableController@store')->name('negotiable.store');

        Route::post('/negotiable/update/{id}', 'NegotiableController@priceUpdate')->name('negotiable.price');
    });

    Route::delete('/advertise/delete/{id}', 'Vendor\AdvertiseController@destroy')->name('vendor.advertise.destroy');
});


// Route::get( '/categories/json', 'CategoryController@getCategoriesJson' )->name( 'categories.json' );
Route::get( '/categories/view', 'Backend\CategoryController@show')->name('category.show');

// Testimonial

Route::get( '{slug}', [ 'uses' => 'PageController@getPage' ] )->where( 'slug', '([A-Za-z0-9\-\/]+)' );
