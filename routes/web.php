<?php

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

Route::get('/', function () {
    return view('welcome');
});
// Auth::routes();
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');

/* ------------------------------------------------------------------------------
 |									需要會員認證
 * -----------------------------------------------------------------------------*/
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function(){

	/* ----------------- 管理後台首頁 ----------------- */
	Route::get('/index', 'IndexController@index')->name('admin_index');

	/* ----------------- 管理後台 - 會員管理 ----------------- */
	Route::group(['prefix' => 'member'],function(){
		/* 首頁 */
		Route::get('/', 'MemberController@index');
		Route::get('/index', 'MemberController@index')
				->name('admin_member_index');

		/* 首頁 - Update */
		Route::post('/edit', 'MemberController@edit')
				->name('admin_member_index_edit');

		/* 分類 */
		Route::group(['prefix' => 'category'], function(){
			/* List */
			Route::get('/'		 	, 'MemberController@category');
			Route::get('/index'		, 'MemberController@category')
				 ->name('admin_member_category');

			/* Create */
			Route::match(['get','post'],'/create', 'MemberController@categoryCreate')
				 	->name('admin_member_category_create');

			/* Edit */
			Route::match(['get','post'],'/edit/{role}', 'MemberController@categoryEdit')
				 	->name('admin_member_category_edit')
				 	->where('role','[0-9]+');	

			/* Delete Single */	
			Route::post('/delete/{id}', 'MemberController@categoryDelete')
				 	->name('admin_member_category_delete')
				 	->where('id','[0-9]+');

			/* Multiple Delete and Hide , Show*/	
			Route::post('/MultipleAction', 'MemberController@categoryMultipleAction')
				 	->name('admin_member_category_multiple_action');
			Route::get('/ajaxCategoryRelatedItem', 'MemberController@ajaxCategoryRelatedItem')
				 	->name('admin_member_ajax_category_related_item');						
		});
		/* 項目 */
		Route::group(['prefix' => 'item'], function(){
			/* List */
			Route::get('/'		 	, 'MemberController@item');
			Route::get('/index'		, 'MemberController@item')
				 	->name('admin_member_item');

			/* Create */
			Route::match(['get','post'],'/create', 'MemberController@itemCreate')
				 	->name('admin_member_item_create');

			/* Edit */
			Route::match(['get','post'],'/edit/{user}', 'MemberController@itemEdit')
				 	->name('admin_member_item_edit')
				 	->where('user','[0-9]+');	

			/* Delete Single */	
			Route::post('/delete/{id}', 'MemberController@itemDelete')
					->name('admin_member_item_delete')->where('id','[0-9]+');

			/* Multiple Delete and Hide */	
			Route::post('/MultipleAction', 'MemberController@itemMultipleAction')
					->name('admin_member_item_multiple_action');			
		});		
	});
	/* ----------------- 管理後台 - 最新消息 ----------------- */
	Route::group(['prefix' => 'news'],function(){
		/* 首頁 */
		Route::get('/', 'NewsController@index');
		Route::get('/index', 'NewsController@index')
				->name('admin_news_index');

		/* 首頁 - Update */
		Route::post('/edit', 'NewsController@edit')
				->name('admin_news_index_edit');

		/* 分類 */
		Route::group(['prefix' => 'category'], function(){
			/* List */
			Route::get('/'		 	, 'NewsController@category');
			Route::get('/index'		, 'NewsController@category')
				 ->name('admin_news_category');

			/* Create */
			Route::match(['get','post'],'/create', 'NewsController@categoryCreate')
				 	->name('admin_news_category_create');

			/* Edit */
			Route::match(['get','post'],'/edit/{id}', 'NewsController@categoryEdit')
				 	->name('admin_news_category_edit')
				 	->where('id','[0-9]+');	

			/* Delete Single */	
			Route::post('/delete/{id}', 'NewsController@categoryDelete')
				 	->name('admin_news_category_delete')
				 	->where('id','[0-9]+');

			/* Multiple Delete and Hide , Show*/	
			Route::post('/MultipleAction', 'NewsController@categoryMultipleAction')
				 	->name('admin_news_category_multiple_action');
			Route::get('/ajaxCategoryRelatedItem', 'NewsController@ajaxCategoryRelatedItem')
				 	->name('admin_news_ajax_category_related_item');						
		});
		/* 項目 */
		Route::group(['prefix' => 'item'], function(){
			/* List */
			Route::get('/'		 	, 'NewsController@item');
			Route::get('/index'		, 'NewsController@item')
				 	->name('admin_news_item');

			/* Create */
			Route::match(['get','post'],'/create', 'NewsController@itemCreate')
				 	->name('admin_news_item_create');

			/* Edit */
			Route::match(['get','post'],'/edit/{id}', 'NewsController@itemEdit')
				 	->name('admin_news_item_edit')
				 	->where('id','[0-9]+');	

			/* Delete Single */	
			Route::post('/delete/{id}', 'NewsController@itemDelete')
					->name('admin_news_item_delete')->where('id','[0-9]+');

			/* Multiple Delete and Hide */	
			Route::post('/MultipleAction', 'NewsController@itemMultipleAction')
					->name('admin_news_item_multiple_action');			
		});		
	});
	/* ----------------- 管理後台 - 商品 ----------------- */
	Route::group(['prefix' => 'product'], function(){
		/* 首頁 */
		Route::get('/', 'ProductController@index');
		Route::get('/index', 'ProductController@index')
			 	->name('admin_product_index');	
		/* 首頁 - Update */
		Route::post('/edit', 'ProductController@edit')
				->name('admin_product_index_edit');	
		/* 分類 */
		Route::group(['prefix' => 'category'], function(){
			/* List */
			Route::get('/{category_id?}'		 	, 'ProductController@category')
					->where('category_id','[0-9]+');
			Route::get('/index/{category_id?}'		, 'ProductController@category')
				 	->name('admin_product_category')
				 	->where('category_id','[0-9]+');

			/* Create */
			Route::match(['get','post'],'/create', 'ProductController@categoryCreate')
				 	->name('admin_product_category_create');

			/* Edit */
			Route::match(['get','post'],'/edit/{id}', 'ProductController@categoryEdit')
				 	->name('admin_product_category_edit')
				 	->where('id','[0-9]+');	

			/* Delete Single */	
			Route::post('/delete/{id}', 'ProductController@categoryDelete')
				 	->name('admin_product_category_delete')
				 	->where('id','[0-9]+');

			/* Multiple Delete and Hide */	
			Route::post('/MultipleAction', 'ProductController@categoryMultipleAction')
				 	->name('admin_product_category_multiple_action');
			Route::get('/ajaxCategoryRelatedItem', 'ProductController@ajaxCategoryRelatedItem')
				 	->name('admin_product_ajax_category_related_item');						
		});	
		/* 項目 */
		Route::group(['prefix' => 'item'], function(){
			/* List */
			Route::get('/'		 	, 'ProductController@item');
			Route::get('/index'		, 'ProductController@item')
				 	->name('admin_product_item');

			/* Create */
			Route::match(['get','post'],'/create', 'ProductController@itemCreate')
				 	->name('admin_product_item_create');

			/* Edit */
			Route::match(['get','post'],'/edit/{productItem}', 'ProductController@itemEdit')
				 	->name('admin_product_item_edit')
				 	->where('productItem','[0-9]+');	

			/* Delete Single */	
			Route::post('/delete/{id}', 'ProductController@itemDelete')
				 	->name('admin_product_item_delete')
				 	->where('id','[0-9]+');

			/* Multiple Delete and Hide , Show*/	
			Route::post('/MultipleAction', 'ProductController@itemMultipleAction')
				 	->name('admin_product_item_multiple_action');
			Route::get('/ajaxCategoryRelatedItem', 'ProductController@ajaxCategoryRelatedItem')
				 	->name('admin_product_ajax_item_related_item');

			Route::post('/MultipleFileUpload', 'ProductController@itemMultipleFileUploadAction')
				 	->name('admin_product_item_multiple_file_upload_action');
			/* Multiple Delete and Hide , Show*/
			Route::get('/index_popup'		, 'ProductController@itemPopup')
				 	->name('admin_product_item_popup');
		});							
	});

	/* ----------------- 管理後台 - 檔案管理 ----------------- */
	
});

/* ------------------------------------------------------------------------------
 |									Responsive FileSystem
 * -----------------------------------------------------------------------------*/
Route::group(['before' => 'auth'], function () {
    Route::get('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show')->name('filemanager');
    Route::post('/laravel-filemanager/upload/{type}', '\Unisharp\Laravelfilemanager\controllers\LfmController@upload')->name('filemanager_upload');
    // list all lfm routes here...
});
