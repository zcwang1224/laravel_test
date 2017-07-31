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
	Route::group(['prefix' => 'system'], function(){
		/* 首頁 */
		Route::get('/', 'SystemController@index');
		Route::get('/index', 'SystemController@index')
				// ->middleware('can:system_index_view')
				->name('admin_system_index');

		/* 首頁 - Update */
		Route::post('/edit', 'SystemController@edit')
				// ->middleware('can:system_index_edit')
				->name('admin_system_index_edit');				

	});

	/* ----------------- 管理後台 - 會員管理 ----------------- */
	Route::group(['prefix' => 'member'], function(){
		/* 首頁 */
		Route::get('/', 'MemberController@index')
			->middleware('can:member_index_view');
		Route::get('/index', 'MemberController@index')
				->middleware('can:member_index_view')
				->name('admin_member_index');

		/* 首頁 - Update */
		Route::post('/edit', 'MemberController@edit')
				->middleware('can:member_index_edit')
				->name('admin_member_index_edit');

		/* 分類 */
		Route::group(['prefix' => 'category'], function(){
			/* List */
			Route::get('/'		 	, 'MemberController@category')
				->middleware('can:member_category_view');
			Route::get('/index'		, 'MemberController@category')
				->middleware('can:member_category_view')
				->name('admin_member_category');

			/* Create */
			Route::match(['get','post'],'/create', 'MemberController@categoryCreate')
					->middleware('can:member_category_create')
				 	->name('admin_member_category_create');

			/* Edit View */
			Route::get('/edit/{role}', 'MemberController@categoryEdit')
				 	->name('admin_member_category_edit')
				 	->middleware('can:member_category_view')
				 	->where('role','[0-9]+');
			/* Edit Action */
			Route::post('/edit/{role}', 'MemberController@categoryEdit')
				 	->name('admin_member_category_edit')
				 	->middleware('can:member_category_edit')
				 	->where('role','[0-9]+');				 		

			/* Delete Single */	
			Route::post('/delete/{id}', 'MemberController@categoryDelete')
				 	->name('admin_member_category_delete')
				 	->middleware('can:member_category_delete')
				 	->where('id','[0-9]+');

			/* Multiple Delete and Hide , Show*/	
			Route::post('/MultipleAction', 'MemberController@categoryMultipleAction')
					->middleware('can:member_category_edit')
				 	->name('admin_member_category_multiple_action');
			Route::get('/ajaxCategoryRelatedItem', 'MemberController@ajaxCategoryRelatedItem')
				 	->name('admin_member_ajax_category_related_item');						
		});
		/* 項目 */
		Route::group(['prefix' => 'item'], function(){
			/* List */
			Route::get('/'		 	, 'MemberController@item')
				->middleware('can:member_item_view');
			Route::get('/index'		, 'MemberController@item')
					->middleware('can:member_item_view')
				 	->name('admin_member_item');

			/* Create */
			Route::match(['get','post'],'/create', 'MemberController@itemCreate')
					->middleware('can:member_item_create')
				 	->name('admin_member_item_create');

			/* Edit View */
			Route::get('/edit/{user}', 'MemberController@itemEdit')
				 	->name('admin_member_item_edit')
				 	->middleware('can:member_item_view')
				 	->where('user','[0-9]+');	

			/* Edit Action */
			Route::post('/edit/{user}', 'MemberController@itemEdit')
				 	->name('admin_member_item_edit')
				 	->middleware('can:member_item_edit')
				 	->where('user','[0-9]+');					 	

			/* Delete Single */	
			Route::post('/delete/{id}', 'MemberController@itemDelete')
					->middleware('can:member_item_delete')
					->name('admin_member_item_delete')->where('id','[0-9]+');

			/* Multiple Delete and Hide */	
			Route::post('/MultipleAction', 'MemberController@itemMultipleAction')
					->name('admin_member_item_multiple_action');			
		});		
	});
	/* ----------------- 管理後台 - 最新消息 ----------------- */
	Route::group(['prefix' => 'news'], function(){
		/* 首頁 */
		Route::get('/', 'NewsController@index')
				->middleware(['can:news_index_view']);
		Route::get('/index', 'NewsController@index')
				->middleware(['can:news_index_view'])
				->name('admin_news_index');

		/* 首頁 - Update */
		Route::post('/edit', 'NewsController@edit')
				->middleware(['can:news_index_edit'])
				->name('admin_news_index_edit');

		/* 分類 */
		Route::group(['prefix' => 'category'], function(){
			/* List */
			Route::get('/'		 	, 'NewsController@category')->middleware(['can:news_category_view']);
			Route::get('/index'		, 'NewsController@category')
				->middleware(['can:news_category_view'])
				->name('admin_news_category');

			/* Create */
			Route::match(['get','post'],'/create', 'NewsController@categoryCreate')
					->middleware(['can:news_category_create'])
				 	->name('admin_news_category_create');

			/* Edit */
			Route::get('/edit/{id}', 'NewsController@categoryEdit')
				 	->name('admin_news_category_edit')
				 	->middleware(['can:news_category_view'])
				 	->where('id','[0-9]+');	
			Route::post('/edit/{id}', 'NewsController@categoryEdit')
				 	->name('admin_news_category_edit')
				 	->middleware(['can:news_category_edit'])
				 	->where('id','[0-9]+');	
			/* Delete Single */	
			Route::post('/delete/{id}', 'NewsController@categoryDelete')
				 	->name('admin_news_category_delete')
				 	->middleware(['can:news_category_delete'])
				 	->where('id','[0-9]+');

			/* Multiple Delete and Hide , Show*/	
			Route::post('/MultipleAction', 'NewsController@categoryMultipleAction')
					->middleware(['can:news_category_delete,news_category_edit'])
				 	->name('admin_news_category_multiple_action');
			Route::get('/ajaxCategoryRelatedItem', 'NewsController@ajaxCategoryRelatedItem')
				 	->name('admin_news_ajax_category_related_item');				
		});
		/* 項目 */
		Route::group(['prefix' => 'item'], function(){
			/* List */
			Route::get('/'		 	, 'NewsController@item')->middleware(['can:news_item_view']);
			Route::get('/index'		, 'NewsController@item')
					->middleware(['can:news_item_view'])
				 	->name('admin_news_item');

			/* Create */
			Route::match(['get','post'],'/create', 'NewsController@itemCreate')
					->middleware(['can:news_item_create'])
				 	->name('admin_news_item_create');

			/* Edit view */
			Route::get('/edit/{id}', 'NewsController@itemEdit')
				 	->name('admin_news_item_edit')
				 	->middleware(['can:news_item_view'])
				 	->where('id','[0-9]+');	
			/* Edit action */
			Route::post('/edit/{id}', 'NewsController@itemEdit')
				 	->name('admin_news_item_edit')
				 	->middleware(['can:news_item_edit'])
				 	->where('id','[0-9]+');					 	

			/* Delete Single */	
			Route::post('/delete/{id}', 'NewsController@itemDelete')
					->middleware(['can:news_item_delete'])
					->name('admin_news_item_delete')->where('id','[0-9]+');

			/* Multiple Delete and Hide */	
			Route::post('/MultipleAction', 'NewsController@itemMultipleAction')
					->middleware(['can:news_item_edit,news_item_delete'])
					->name('admin_news_item_multiple_action');			
		});		
	});
	/* ----------------- 管理後台 - 商品 ----------------- */
	Route::group(['prefix' => 'product'], function(){
		/* 首頁 */
		Route::get('/', 'ProductController@index')
				->middleware(['can:product_index_view']);
		Route::get('/index', 'ProductController@index')
				->middleware(['can:product_index_view'])
			 	->name('admin_product_index');	
		/* 首頁 - Update */
		Route::post('/edit', 'ProductController@edit')
				->middleware(['can:product_index_view,product_index_edit'])
				->name('admin_product_index_edit');	
		/* 分類 */
		Route::group(['prefix' => 'category'], function(){
			/* List */
			Route::get('/{category_id?}'		 	, 'ProductController@category')
					->middleware(['can:product_category_view'])
					->where('category_id','[0-9]+');
			Route::get('/index/{category_id?}'		, 'ProductController@category')
				 	->name('admin_product_category')
				 	->middleware(['can:product_category_view'])
				 	->where('category_id','[0-9]+');

			/* Create */
			Route::match(['get','post'],'/create', 'ProductController@categoryCreate')
					->middleware(['can:product_category_create'])
				 	->name('admin_product_category_create');

			/* Edit View */
			Route::get('/edit/{id}', 'ProductController@categoryEdit')
				 	->name('admin_product_category_edit')
				 	->middleware(['can:product_category_view'])
				 	->where('id','[0-9]+');	
			/* Edit action */
			Route::post('/edit/{id}', 'ProductController@categoryEdit')
				 	->name('admin_product_category_edit')
				 	->middleware(['can:product_category_edit'])
				 	->where('id','[0-9]+');	
			/* Delete Single */	
			Route::post('/delete/{id}', 'ProductController@categoryDelete')
				 	->name('admin_product_category_delete')
				 	->middleware(['can:product_category_delete'])
				 	->where('id','[0-9]+');

			/* Multiple Delete and Hide */	
			Route::post('/MultipleAction', 'ProductController@categoryMultipleAction')
					->middleware(['can:product_category_delete'])
				 	->name('admin_product_category_multiple_action');
			Route::get('/ajaxCategoryRelatedItem', 'ProductController@ajaxCategoryRelatedItem')
				 	->name('admin_product_ajax_category_related_item');						
		});	
		/* 項目 */
		Route::group(['prefix' => 'item'], function(){
			/* List */
			Route::get('/'		 	, 'ProductController@item')
					->middleware(['can:product_item_view']);
			Route::get('/index'		, 'ProductController@item')
					->middleware(['can:product_item_view'])
				 	->name('admin_product_item');

			/* Create */
			Route::match(['get','post'],'/create', 'ProductController@itemCreate')
					->middleware(['can:product_item_create'])
				 	->name('admin_product_item_create');

			/* Edit View*/
			Route::get('/edit/{productItem}', 'ProductController@itemEdit')
				 	->name('admin_product_item_edit')
				 	->middleware(['can:product_item_view'])
				 	->where('productItem','[0-9]+');	
			/* Edit Action*/
			Route::post('/edit/{productItem}', 'ProductController@itemEdit')
				 	->name('admin_product_item_edit')
				 	->middleware(['can:product_item_edit'])
				 	->where('productItem','[0-9]+');	
			/* Delete Single */	
			Route::post('/delete/{id}', 'ProductController@itemDelete')
				 	->name('admin_product_item_delete')
				 	->middleware(['can:product_item_delete'])
				 	->where('id','[0-9]+');

			/* Multiple Delete and Hide , Show*/	
			Route::post('/MultipleAction', 'ProductController@itemMultipleAction')
				 	->name('admin_product_item_multiple_action')
				 	->middleware(['can:product_item_edit']);
			Route::get('/ajaxCategoryRelatedItem', 'ProductController@ajaxCategoryRelatedItem')
				 	->name('admin_product_ajax_item_related_item');
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
