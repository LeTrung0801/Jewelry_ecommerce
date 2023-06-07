<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '',
], function(){
    Route::get('','HomeController@index')->name('user-home');
    Route::get('about','HomeController@about')->name('user-about');

    Route::get('login', 'HomeController@login')->name('user-login');
    Route::post('login', 'CustomerController@login')->name('user-login');

    Route::get('register', 'HomeController@register')->name('user-register');
    Route::post('register', 'CustomerController@register')->name('user-register');
	Route::match(['get', 'post'], 'confirm/{token}', 'CustomerController@confirm')->name('user-confirm');
    // Route::post('confirm', 'CustomerController@confirm')->name('user-confirm');

	Route::match(['get', 'post'], 'forgetpass', 'CustomerController@forgetPass')->name('user-forgetpass');
    Route::get('resetpass/{token}','CustomerController@resetPass')->name('user-resetpass');
    Route::post('resetpass/{token}','CustomerController@postResetPass')->name('user-resetpass');

    Route::get('logout', 'CustomerController@logout')->name('user-logout');

    Route::get('info','CustomerController@index')->name('user-info');
    Route::post('edit-info','CustomerController@editUserProfile')->name('edit-user-info');

    Route::get('history','CustomerController@indexHistory')->name('user-history-order');
    Route::post('history-detail/{pk}','CustomerController@orderDetail')->name('user-order-detail');
    Route::post('status','CustomerController@changeStatusOrder')->name('user-order-status');



    Route::get('product-list','ProductController@listUser')->name('product-list');
    Route::get('product-detail/{id}','ProductController@detail')->name('product-detail');
    Route::get('product-collection','ProductController@collection')->name('collection');

    Route::get('cart','CartController@list')->name('cart');
    Route::get('checkout','CartController@checkout')->name('checkout');

    Route::get('add-cart/{pro_id}','CartController@addCart')->name('add-cart');
    Route::post('change-cart/{pk}','CartController@changeCart')->name('change-cart');
    Route::get('delete-item-cart/{pk}','CartController@deleteItemCart')->name('delete-item-cart');
    Route::get('delete-cart','CartController@deleteCart')->name('delete-cart');

    Route::get('order-list','OrderController@cart-list')->name('order-list');
    Route::get('order-detail','OrderController@cart-list')->name('order-detail');
    Route::post('order-store','OrderController@store')->name('order-create');
    Route::post('history-order/{pk}','OrderController@getDetail')->name('history-order');

    Route::post('district','HomeController@getDistrict');
    Route::post('ward','HomeController@getWard');

});


Route::group([
    'prefix' => 'admin',
    // 'namespace' => 'admin'
], function(){
    Route::match(['get', 'post'], 'login', 'AccountController@login')->name('admin-login');
	Route::match(['get', 'post'], 'logout', 'AccountController@logout')->name('admin-logout');

	Route::match(['get', 'post'], 'sendmail', 'AccountController@sendMail')->name('admin-sendmail');
    Route::get('/resetpass/{token}','AccountController@resetPass')->name('admin-resetpassmail');
    Route::post('/resetpass/{token}','AccountController@postResetPass')->name('admin-resetpassmail');

    Route::group([
        'middleware' => 'auth.admin'
    ], function(){
        Route::group([
			'prefix' => 'collection'
		], function() {
			Route::get('', 'CollectionController@list')->name('admin-collection-list');
            Route::get('create', 'CollectionController@create')->name('admin-collection-create');
            Route::post('create', 'CollectionController@store')->name('admin-collection-create');
            Route::get('edit/{pk}', 'CollectionController@edit')->name('admin-collection-edit');
            Route::post('edit/{pk}', 'CollectionController@update')->name('admin-collection-edit');
            Route::post('delete/{pk}', 'CollectionController@delete')->name('admin-collection-delete');
            Route::get('export', 'CollectionController@export')->name('admin-collection-export');
		});
        Route::group([
			'prefix' => 'category'
		], function() {
			Route::get('', 'CategoryController@list')->name('admin-category-list');
            Route::get('create', 'CategoryController@create')->name('admin-category-create');
            Route::post('create', 'CategoryController@store')->name('admin-category-create');
            Route::get('edit/{pk}', 'CategoryController@edit')->name('admin-category-edit');
            Route::post('edit/{pk}', 'CategoryController@update')->name('admin-category-edit');
            Route::post('delete/{pk}', 'CategoryController@delete')->name('admin-category-delete');
            Route::get('export', 'CategoryController@export')->name('admin-category-export');
		});

        Route::group([
			'prefix' => 'product'
		], function() {
			Route::get('', 'ProductController@list')->name('admin-product-list');
            Route::post('', 'ProductController@listShort')->name('admin-product-list');
            Route::get('create', 'ProductController@create')->name('admin-product-create');
            Route::post('create', 'ProductController@store')->name('admin-product-create');
            Route::get('edit/{pk}', 'ProductController@edit')->name('admin-product-edit');
            Route::post('edit/{pk}', 'ProductController@update')->name('admin-product-edit');
            Route::post('delete/{pk}', 'ProductController@delete')->name('admin-product-delete');
		});

        Route::group([
			'prefix' => 'customer'
		], function() {
			Route::get('', 'CustomerController@list')->name('admin-customer-list');
            Route::post('delete/{pk}', 'CustomerController@delete')->name('admin-customer-delete');
            Route::post('active','CustomerController@changeStatus')->name('admin-customer-active');
		});

        Route::group([
			'prefix' => 'account'
		], function() {
			Route::get('', 'AccountController@list')->name('admin-account-list');
            Route::get('create', 'AccountController@create')->name('admin-account-create');
            Route::post('create', 'AccountController@save')->name('admin-account-create');
            Route::get('edit/{pk}', 'AccountController@edit')->name('admin-account-edit');
            Route::post('edit/{pk}', 'AccountController@update')->name('admin-account-edit');
            Route::post('delete/{pk}', 'AccountController@delete')->name('admin-account-delete');
            Route::post('active','AccountController@changeStatus')->name('admin-account-active');
            Route::get('export', 'AccountController@export')->name('admin-account-export');
            // Route::get('search', 'AccountController@list')->name('admin-account-search');
		});

        Route::group([
			'prefix' => 'order'
		], function() {
			Route::get('', 'OrderController@list')->name('admin-order-list');
            Route::get('complete', 'OrderController@list_s1')->name('admin-order-list_s1');
            Route::get('canceled', 'OrderController@list_s2')->name('admin-order-list_s2');
            Route::post('product-detail/{pk}','OrderController@orderDetail')->name('admin-order-detail');
            Route::post('status','OrderController@status')->name('admin-order-status');
            Route::post('delete/{pk}','OrderController@delete')->name('admin-order-delete');
		});

        Route::group([
			'prefix' => 'warehouse'
		], function() {
			Route::get('', 'WareHouseController@list')->name('admin-warehouse-list');
            Route::post('add-pro', 'WareHouseController@add')->name('admin-warehouse-add');
            Route::get('create', 'WareHouseController@create')->name('admin-warehouse-create');
            Route::post('create', 'WareHouseController@save')->name('admin-warehouse-create');
            Route::get('edit/{pk}', 'WareHouseController@edit')->name('admin-warehouse-edit');
            Route::post('edit/{pk}', 'WareHouseController@update')->name('admin-warehouse-edit');
            Route::get('delete-item/{pk}', 'WareHouseController@delete')->name('admin-warehouse-delete-item');
		});

        Route::group([
			'prefix' => 'csv'
		], function() {
			Route::get('product-export', 'CSVController@exportProduct')->name('admin-product-export');
		});

        Route::match(['get', 'post'], 'profile', 'AccountController@profile')->name('admin-profile');
        Route::get('','AccountController@index')->name('admin-home');
    });
});
