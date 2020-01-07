<?php

use Illuminate\Support\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('view:cache');
    return 'DONE'; //Return anything
});

Route::get('/backend/mailable', function () {
    $reply = App\Models\Frontend\Messages\Replies::find(1);

    return new App\Mail\Frontend\MessageReply($reply, 'test');
});
    
Route::get('/mailable/order', function (Request $request) {
    $order = App\Models\Order::find(20);
    return new App\Mail\Backend\NewOrderPlacedMail($order);
});

Route::get('/', 'HomeController@index')->name('welcome');
Route::get('/contact-us', 'HomeController@contact_us')->name('contact-us');
Route::post('/contact-us', 'MessageController@post')->name('message-us');
Route::get('/about-us', 'HomeController@about_us')->name('about-us');
Route::get('/privacy-policy', 'HomeController@privacy_policy')->name('privacy.policy');

Route::prefix('product')->group(function(){
    // Compare Routes
    Route::get('/compare-table', 'Product\CompareController@index')->name('user.compare.table');
    Route::get('/compare-table/add/{product}', 'Product\CompareController@add')->name('compare.item.add');
    Route::get('/compare-table/remove/{model}', 'Product\CompareController@destroy')->name('compare.item.remove');

    // Review Routes
    Route::post('/review/post', 'Product\ReviewController@store')->name('post.review');
    Route::get('/review/edit/{id}', 'Product\ReviewController@edit')->name('edit.review');
    Route::post('/review/update', 'Product\ReviewController@update')->name('update.review');

    // View Product
    Route::get('/{category}/{subcategory}/{product}/{slug}', 'HomeController@view_product')->name('view.product');

});

Route::prefix('user')->group(function(){

    // Cart Routes
    Route::get('/cart', 'Customer\CartController@index')->name('user.cart');
    Route::post('/cart/item/store', 'Customer\CartController@store')->name('store.cart.item');
    Route::post('/cart/item/udpate', 'Customer\CartController@update')->name('update.cart.item');
    Route::post('/cart/udpate', 'Customer\CartController@update')->name('update.user.cart');
    Route::get('/cart/add/{product}/{sku}', 'Customer\CartController@add')->name('cart.item.add');
    Route::get('/cart/remove/{product}/{sku}', 'Customer\CartController@destroy')->name('cart.item.remove');

});

// Shop Routes
Route::get('/shop', 'ShopController@index')->name('shop');
Route::get('shop/products/{category}/{subcategory}', 'ShopController@category_subcategory_products')->name('shop.products.category.subcategory');
Route::get('shop/tag/products/{tag}', 'ShopController@tag_search')->name('shop.products.tag');
Route::post('shop/products/search/price', 'ShopController@price_search')->name('shop.products.price.search');
Route::get('shop/products/search/price/{range}', 'ShopController@get_price_search')->name('shop.products.price.search.result');
Route::post('shop/products/search/keyword', 'ShopController@search')->name('shop.products.search');
Route::get('shop/products/search/keyword/{keyword}', 'ShopController@search_keyword')->name('shop.products.search.result');
Route::get('shop/products/live-search/keyword/{keyword}', 'ShopController@live_search')->name('shop.products.live.search');

// Test Route
Route::get('/product/recent', 'HomeController@recently_viewed')->name('product.recent');
Route::get('/product/available/{model}/{sku}', 'HomeController@is_available')->name('product.test');

// Socialite Login routes
Route::get('login/{driver}', 'Auth\LoginController@redirectToProvider')->name('social.login');
Route::get('login/{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.register');

// Ajax Request
Route::get('/product/{model}', 'HomeController@single_product')->name('single.product');
Route::get('/product/{product}/attribute/{sku}', 'HomeController@single_attribute')->name('single.attribute');
Route::get('/category/{category}/subcategories', 'ShopController@category_subcategories')->name('category.subcategories');

// Auth Routes for front end
Auth::routes(['verify' => true]);

Route::middleware(['verified', 'auth'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    // Reply Routes
    Route::post('/review/reply/post', 'Product\Review\ReplyController@store')->name('post.reply');
    Route::get('/review/reply/edit/{id}', 'Product\Review\ReplyController@edit')->name('edit.reply');
    Route::post('/review/reply/update', 'Product\Review\ReplyController@update')->name('update.reply');
    Route::get('/order/check-out', 'OrderController@check_out')->name('order.checkout');
    Route::post('/order/check-out', 'OrderController@place_order')->name('order.place');

    Route::prefix('user')->group(function(){

        // Compare Routes
        Route::get('/wishes', 'Customer\WishController@index')->name('user.wishes');
        Route::get('/wish/add/{product}/{attribute}', 'Customer\WishController@addToWish')->name('wish.item.add');
        Route::get('/wish/remove/{product}/{attribute}', 'Customer\WishController@destroy')->name('wish.item.remove');
        
        // Cart Routes
        Route::get('/address-book', 'customer\AddressController@index')->name('user.address.book');
        Route::get('/account', 'customer\CustomerController@profile')->name('user.account');

        // Order Routes
        Route::prefix('orders')->group(function(){
            Route::get('/', 'OrderController@history')->name('user.order.history');
            Route::get('/{order}/details', 'OrderController@show')->name('user.order.view');
            Route::get('/{order}/cancel', 'OrderController@cancel')->name('user.order.cancel');
        });
    });

});

// Routes for Admin Panel...
Route::prefix('backend')->group(function(){

    // Login/Logout Routes...
    Route::get('login', 'Backend\User\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Backend\User\Auth\LoginController@login');

    //User Section   
    Route::prefix('user')->group(function(){

        // Registration Routes...
        Route::get('create', 'Backend\UserController@create')->name('admin.user.create');
        Route::post('store', 'Backend\UserController@store')->name('admin.user.store');
        Route::post('password/create', 'Backend\User\Auth\PasswordController@createPassword')->name('admin.create.password');

        // Verification Routes...
        Route::get('verify/{id}/{verify_token}', 'Backend\User\Auth\VerificationController@verify')->name('admin.verify');

        Route::post('logout', 'Backend\User\Auth\LoginController@logout')->name('admin.logout');

        // Password Reset Routes...
        Route::get('password/reset', 'Backend\User\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        Route::post('password/email', 'Backend\User\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        Route::get('password/reset/{token}', 'Backend\User\Auth\PasswordController@showResetForm')->name('admin.password.reset');
        Route::post('password/reset', 'Backend\User\Auth\PasswordController@reset')->name('admin.password.update');
        
        // Admin middleware redirect routes
        Route::get('status', 'Backend\UserController@status_notice')->name('admin.status.notice');
        
        Route::get('{user}/apporve', 'Backend\UserController@approve')->name('admin.user.approve');
        Route::get('{user}/details', 'Backend\UserController@show')->name('admin.user.details');
        Route::post('{user}/update', 'Backend\UserController@update')->name('admin.user.update');
        Route::get('{user}/remove', 'Backend\UserController@remove')->name('admin.user.remove');
        Route::get('{id}/restore', 'Backend\UserController@restore')->name('admin.user.restore');
        Route::get('{id}/delete', 'Backend\UserController@delete')->name('admin.user.delete');

        // Admin profile routes
        Route::get('profile', 'Backend\User\PofileController@show')->name('admin.profile');
        Route::get('profile/edit', 'Backend\User\PofileController@edit')->name('admin.profile.edit');
        Route::post('update/profile', 'Backend\User\PofileController@update')->name('admin.profile.update');
        Route::get('password/change', 'Backend\ProfileController@change_password')->name('admin.password.change');
        Route::post('password/change', 'Backend\ProfileController@update_password')->name('admin.password.update');

        // Notification routes
        Route::get('notifications', 'Backend\User\NotificationController@index')->name('admin.notifications');
        Route::get('notification/markasread/{id}', 'Backend\User\NotificationController@markAsRead')->name('admin.notification.markasread');
        Route::get('notifications/markallasread', 'Backend\User\NotificationController@markAllAsRead')->name('admin.notifications.markallasread');
        Route::get('notification/markasunread/{id}', 'Backend\User\NotificationController@markAsUnread')->name('admin.notification.markasunread');
        Route::get('notification/delete/{id}', 'Backend\User\NotificationController@delete')->name('admin.notification.delete');
        Route::get('notifications/delete', 'Backend\User\NotificationController@deleteAll')->name('admin.notifications.deleteall');
    });

    // Dashboard
    Route::get('dashboard', 'Backend\UserController@dashboard')->name('admin.dashboard');
    Route::get('users', 'Backend\UserController@index')->name('admin.users');
    Route::get('users/trash', 'Backend\UserController@trash')->name('admin.users.trash');
    
    // About Pages
    Route::get('page/about-us', 'Pages\AboutPageController@index')->name('admin.page.about-us');
    Route::get('page/about-us/content', 'Pages\AboutPageController@create')->name('admin.page.about-us.content.create');
    Route::post('page/about-us/content', 'Pages\AboutPageController@store')->name('admin.page.about-us.content.store');
    Route::get('page/about-us/content/edit', 'Pages\AboutPageController@edit')->name('admin.page.about-us.content.edit');
    Route::post('page/about-us/content/update', 'Pages\AboutPageController@update')->name('admin.page.about-us.content.update');
    Route::get('page/about-us/content/view', 'Pages\AboutPageController@view')->name('admin.page.about-us.content.view');

    // Home Pages
    Route::get('page/home-page', 'Pages\TradeMarkController@index')->name('admin.page.trade-marks');
    Route::get('page/trade-marks/logo', 'Pages\TradeMarkController@create_logo')->name('admin.page.trade-marks.logo.create');
    Route::post('page/trade-marks/logo', 'Pages\TradeMarkController@store_logo')->name('admin.page.trade-marks.logo.store');
    Route::get('page/trade-marks/logo/edit', 'Pages\TradeMarkController@edit_logo')->name('admin.page.trade-marks.logo.edit');
    Route::post('page/trade-marks/logo/update', 'Pages\TradeMarkController@update_logo')->name('admin.page.trade-marks.logo.update');
    Route::get('page/trade-marks/logo/view', 'Pages\TradeMarkController@view_logo')->name('admin.page.trade-marks.logo.view');

    Route::get('page/trade-marks/trade/{trade}', 'Pages\TradeMarkController@create')->name('admin.page.trade-marks.type.create');
    Route::post('page/trade-marks/trade/{trade}', 'Pages\TradeMarkController@store')->name('admin.page.trade-marks.type.store');
    Route::get('page/trade-marks/trade/{trade}/edit', 'Pages\TradeMarkController@edit')->name('admin.page.trade-marks.type.edit');
    Route::post('page/trade-marks/trade/{trade}/update', 'Pages\TradeMarkController@update')->name('admin.page.trade-marks.type.update');
    Route::get('page/trade-marks/trade/{trade}/view', 'Pages\TradeMarkController@view_email')->name('admin.page.trade-marks.type.view');    

    // Roles routes
    Route::get('roles', 'Backend\User\RoleController@index')->name('admin.roles');
    Route::get('role/add', 'Backend\User\RoleController@create')->name('admin.role.create');
    Route::post('role/store', 'Backend\User\RoleController@store')->name('admin.role.store');
    Route::get('role/details/{role}', 'Backend\User\RoleController@show')->name('admin.role.details');
    Route::get('role/edit/{role}', 'Backend\User\RoleController@edit')->name('admin.role.edit');
    Route::post('role/update', 'Backend\User\RoleController@update')->name('admin.role.update');
    Route::get('role/delete/{role}', 'Backend\User\RoleController@destroy')->name('admin.role.delete');

    // Status routes
    Route::get('statuses', 'Backend\User\StatusController@index')->name('admin.statuses');
    Route::get('status/add', 'Backend\User\StatusController@create')->name('admin.status.create');
    Route::post('status/store', 'Backend\User\StatusController@store')->name('admin.status.store');
    Route::get('status/details/{status}', 'Backend\User\StatusController@show')->name('admin.status.details');
    Route::get('status/edit/{status}', 'Backend\User\StatusController@edit')->name('admin.status.edit');
    Route::post('status/update', 'Backend\User\StatusController@update')->name('admin.status.update');
    Route::get('status/delete/{status}', 'Backend\User\StatusController@destroy')->name('admin.status.delete');

    //Product Section   
    // Categories routes
    Route::get('categories', 'Product\CategoryController@index')->name('admin.categories');
    Route::get('category/add', 'Product\CategoryController@create')->name('admin.category.add');
    Route::post('category/store', 'Product\CategoryController@store')->name('admin.category.store');
    Route::get('category/{id}/details', 'Product\CategoryController@show')->name('admin.category.details');
    Route::get('category/{id}/edit', 'Product\CategoryController@edit')->name('admin.category.edit');
    Route::post('category/update', 'Product\CategoryController@update')->name('admin.category.update');
    Route::get('category/{id}/delete', 'Product\CategoryController@destroy')->name('admin.category.delete');
    Route::get('category/{id}/subcategories', 'Product\CategoryController@subCategories')->name('admin.category.subcategories');

    // Subcategories routes
    Route::get('subcategories', 'Product\SubcategoryController@index')->name('admin.subcategories');
    Route::get('subcategory/add', 'Product\SubcategoryController@create')->name('admin.subcategory.add');
    Route::post('subcategory/store', 'Product\SubcategoryController@store')->name('admin.subcategory.store');
    Route::get('subcategory/{id}/details', 'Product\SubcategoryController@show')->name('admin.subcategory.details');
    Route::get('subcategory/{id}/edit', 'Product\SubcategoryController@edit')->name('admin.subcategory.edit');
    Route::post('subcategory/update', 'Product\SubcategoryController@update')->name('admin.subcategory.update');
    Route::get('subcategory/{id}/delete', 'Product\SubcategoryController@destroy')->name('admin.subcategory.delete');

    // Tags routes
    Route::get('tags', 'Product\TagController@index')->name('admin.tags');
    Route::get('tag/add', 'Product\TagController@create')->name('admin.tag.add');
    Route::post('tag/store', 'Product\TagController@store')->name('admin.tag.store');
    Route::get('tag/details/{tag}', 'Product\TagController@show')->name('admin.tag.details');
    Route::get('tag/edit/{tag}', 'Product\TagController@edit')->name('admin.tag.edit');
    Route::post('tag/update', 'Product\TagController@update')->name('admin.tag.update');
    Route::get('tag/delete/{tag}', 'Product\TagController@destroy')->name('admin.tag.delete');

    // Home Banner routes
    Route::get('sliders', 'Pages\SliderController@index')->name('admin.sliders');
    Route::get('slider/add', 'Pages\SliderController@create')->name('admin.slider.add');
    Route::post('slider/store', 'Pages\SliderController@store')->name('admin.slider.store');
    Route::get('slider/{id}/details', 'Pages\SliderController@show')->name('admin.slider.details');
    Route::get('slider/{id}/edit', 'Pages\SliderController@edit')->name('admin.slider.edit');
    Route::post('slider/update', 'Pages\SliderController@update')->name('admin.slider.update');
    Route::get('slider/{id}/delete', 'Pages\SliderController@destroy')->name('admin.slider.delete');

    // Home Banner routes
    Route::get('banners', 'Pages\BannerController@index')->name('admin.banners');
    Route::get('banner/add', 'Pages\BannerController@create')->name('admin.banner.add');
    Route::post('banner/store', 'Pages\BannerController@store')->name('admin.banner.store');
    Route::get('banner/{id}/details', 'Pages\BannerController@show')->name('admin.banner.details');
    Route::get('banner/{id}/edit', 'Pages\BannerController@edit')->name('admin.banner.edit');
    Route::post('banner/update', 'Pages\BannerController@update')->name('admin.banner.update');
    Route::get('banner/{id}/delete', 'Pages\BannerController@destroy')->name('admin.banner.delete');

    // Home Deals routes
    Route::get('offers', 'OfferController@index')->name('admin.offers');
    Route::get('offer/add', 'OfferController@create')->name('admin.offer.add');
    Route::post('offer/store', 'OfferController@store')->name('admin.offer.store');
    Route::get('offer/{id}/details', 'OfferController@show')->name('admin.offer.details');
    Route::get('offer/{id}/edit', 'OfferController@edit')->name('admin.offer.edit');
    Route::post('offer/update', 'OfferController@update')->name('admin.offer.update');
    Route::get('offer/{id}/delete', 'OfferController@destroy')->name('admin.offer.delete');

    // Products routes
    Route::get('products', 'ProductController@index')->name('admin.products');
    Route::get('product/add', 'ProductController@create')->name('admin.product.add');
    Route::post('product/store', 'ProductController@store')->name('admin.product.store');
    Route::get('product/details/{id}', 'ProductController@show')->name('admin.product.details');
    Route::get('product/publish/{id}', 'ProductController@publish')->name('admin.product.publish');
    Route::get('product/{category}/{subcategory}/{product}/{slug}', 'ProductController@preview')->name('admin.product.preview');
    Route::get('product/edit/{id}', 'ProductController@edit')->name('admin.product.edit');
    Route::post('product/update', 'ProductController@update')->name('admin.product.update');
    Route::get('product/archive/{id}', 'ProductController@delete')->name('admin.product.delete')->middleware(['role:CSR', 'role:Master']);
    Route::get('products/archive', 'ProductController@archive')->name('admin.products.archive');
    Route::get('product/restore/{id}', 'ProductController@restore')->name('admin.product.restore');
    Route::get('product/destroy/{id}', 'ProductController@destroy')->name('admin.product.destroy')->middleware('role:Admin');

    // Ajax Request for products
    Route::post('product/input/validate', 'ProductController@validate_input')->name('admin.products.validate');
    Route::post('product/pictures/upload', 'ProductController@upload_file')->name('admin.pictures.upload');
    Route::post('product/picture/delete', 'ProductController@remove_file')->name('admin.picture.delete');
    Route::post('product/pictures/delete', 'ProductController@remove_files')->name('admin.pictures.delete');
    Route::post('product/feature/update', 'ProductController@update_product_feature')->name('admin.product.feature.update');

    // Attribute routes
    Route::get('product/{model}/attribute/add', 'Product\AttributeController@create')->name('admin.product.attribute.add');
    Route::post('attribute/store', 'Product\AttributeController@store')->name('admin.product.attribute.store');
    Route::get('product/attribute/edit/{attribute}', 'Product\AttributeController@edit')->name('admin.product.attribute.edit');
    Route::get('attribute/details/{attribute}', 'Product\AttributeController@show')->name('admin.product.attribute.details');
    Route::post('product/attribute/update', 'Product\AttributeController@update')->name('admin.product.attribute.update');
    Route::get('product/attribute/delete/{attribute}', 'Product\AttributeController@destroy')->name('admin.product.attribute.delete');

    // Product Meta routes
    Route::get('product/{model}/meta', 'Product\MetaController@show')->name('admin.product.meta');
    Route::get('product//{model}/meta/edit', 'Product\MetaController@edit')->name('admin.product.meta.edit');
    Route::post('product/meta/update', 'Product\MetaController@update')->name('admin.product.meta.update');
    
    // Product Meta routes
    Route::get('product/{model}/report', 'Product\ReportController@show')->name('admin.product.report');
    
    // Ajax Request for attributes
    Route::get('attribute/images/{model}/{sku}', 'Product\AttributeController@getProductImages')->name('admin.attribute.images');

    // Features routes
    Route::get('features', 'Product\FeatureController@index')->name('admin.features');
    Route::get('feature/add', 'Product\FeatureController@create')->name('admin.feature.add');
    Route::post('feature/store', 'Product\FeatureController@store')->name('admin.feature.store');
    Route::get('feature/details/{id}', 'Product\FeatureController@show')->name('admin.feature.details');
    Route::get('feature/edit/{id}', 'Product\FeatureController@edit')->name('admin.feature.edit');
    Route::post('feature/update', 'Product\FeatureController@update')->name('admin.feature.update');
    Route::get('feature/delete/{id}', 'Product\FeatureController@destroy')->name('admin.feature.delete');

    // Ajax Request for labels

    // Discount routes
    Route::get('products/discounts', 'Product\DiscountController@index')->name('admin.products.discounts');
    Route::get('products/discount/add', 'Product\DiscountController@create')->name('admin.products.discount.add');
    Route::post('products/discount/add', 'Product\DiscountController@batch_store')->name('admin.products.discount.store');
    // Route::get('product/discount/add', 'Product\DiscountController@create')->name('admin.discount.add');
    Route::post('product/discount/add', 'Product\DiscountController@store')->name('admin.product.discount.store');
    Route::get('product/discount/details/{id}', 'Product\DiscountController@show')->name('admin.discount.details');
    Route::get('product/discount/edit/{id}', 'Product\DiscountController@edit')->name('admin.discount.edit');
    Route::post('product/discount/update', 'Product\DiscountController@update')->name('admin.discount.update');
    Route::get('product/discount/delete/{discount}', 'Product\DiscountController@destroy')->name('admin.discount.delete');
    
    // Ajax Request for discounts

    // Order Routes
    Route::prefix('orders')->group(function(){
        Route::get('/', 'OrderController@index')->name('admin.orders');
        Route::get('/details/{order}', 'OrderController@view')->name('admin.order.details');
        Route::get('/{order}/edit', 'OrderController@edit')->name('admin.order.edit');
        Route::post('/update', 'OrderController@update')->name('admin.order.update');
        Route::get('/{order}/delete', 'OrderController@delete')->name('admin.order.delete');
    });

    // Invoice Routes
    Route::prefix('invoice')->group(function(){
        Route::get('/{invoice}/details', 'Order\InvoiceController@show')->name('admin.order.invoice.details');
        Route::post('/update', 'Order\InvoiceController@update')->name('admin.order.invoice.update');
        Route::get('/{invoice}/print', 'Order\InvoiceController@export')->name('admin.order.invoice.print');
        Route::get('/{invoice}/export', 'Order\InvoiceController@export')->name('admin.order.invoice.export');
    });

    // Review routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('reviews', 'Product\ReviewController@index')->name('admin.reviews');
        Route::get('product/{id}/reviews', 'Product\ReviewController@product_reviews')->name('admin.product.reviews');
        Route::get('product/review/{id}', 'Product\ReviewController@show')->name('admin.review.details');
        Route::get('product/review/{id}/update', 'Product\ReviewController@updateReview')->name('admin.review.status.update');
        Route::get('product/review/{id}/delete', 'Product\ReviewController@delete')->name('admin.review.delete');
        Route::get('reviews/trash', 'Product\ReviewController@trash')->name('admin.reviews.trash');
        Route::get('review/restore/{id}', 'Product\ReviewController@restore')->name('admin.review.restore');
        Route::get('review/destroy/{id}', 'Product\ReviewController@destroy')->name('admin.review.destroy');

        // Frontend Routes for Admin Panel
        Route::get('customer/details/{id}', 'CustomerController@viewCustomer')->name('admin.customer.details');
        //Review Routes for Admin Panel

        // Reply Routes
        Route::get('/review/replies', 'Product\Review\ReplyController@index')->name('admin.replies');
        Route::post('/review/reply/post', 'Product\Review\ReplyController@store')->name('admin.reply.post');
        Route::get('/review/reply/edit/{id}', 'Product\Review\ReplyController@edit')->name('admin.reply.edit');
        Route::get('/review/reply/{id}', 'Product\Review\ReplyController@show')->name('admin.reply.details');
        Route::post('/review/reply/update', 'Product\Review\ReplyController@update')->name('admin.reply.update');
        Route::get('product//review/reply/{id}/update', 'Product\Review\ReplyController@updateReply')->name('admin.reply.status.update');
        Route::get('/review/reply/{id}/delete', 'Product\Review\ReplyController@destroy')->name('admin.reply.delete');
        Route::get('/review/replies/trash', 'Product\Review\ReplyController@trash')->name('admin.replies.trash');

        // Message Routes
        Route::get('messages', 'MessageController@index')->name('admin.messages');
        Route::get('customer/{id}/messages', 'MessageController@customer_messages')->name('admin.customer.messages');
        Route::get('customer/message/{id}', 'MessageController@show')->name('admin.message.details');
        Route::get('customer/message/{id}/update', 'MessageController@updateReview')->name('admin.message.status.update');
        Route::get('message/destroy/{id}', 'MessageController@destroy')->name('admin.message.destroy');
        
    });

    // Reply Routes
    Route::get('/message/replies', 'Messages\ReplyController@index')->name('admin.message.replies');
    Route::post('/message/reply/post', 'Messages\ReplyController@reply')->name('admin.message.reply.post');
    Route::get('/message/reply/{id}', 'Messages\ReplyController@show')->name('admin.message.reply.details');
    Route::get('/message/reply/{id}/delete', 'Messages\ReplyController@destroy')->name('admin.message.reply.delete');

    
    // Route::middleware(['first', 'second'])->group(function () {
    // });
});

// Authentication Routes for Backend Panel...
// Route::prefix('admin')->middleware('verified')->group(function () {
    
// }





