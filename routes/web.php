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

// frontend
	// home
		Route::get('/', 'Frontend\FrontendController@home')
			->name('frontend.home');
			Route::get('/home', 'Frontend\FrontendController@home')
			->name('frontend.home');
	// home
	// about
		Route::get('/about', 'Frontend\FrontendController@about')
			->name('frontend.about');
	// about
	// contact
		Route::get('/contact', 'Frontend\FrontendController@contact')
			->name('frontend.contact');
		Route::post('/contact/store', 'Frontend\FrontendController@contactStore')
			->name('frontend.contact.store');
	// contact
	// product
		Route::get('/product', 'Frontend\FrontendController@product')
			->name('frontend.product');
		Route::get('/product/{slug}', 'Frontend\FrontendController@product')
			->name('frontend.product.category');
		Route::get('/product/{slug}/{subslug}', 'Frontend\FrontendController@product')
			->name('frontend.product.select');
	// product
	// solutions
		Route::get('/solutions', 'Frontend\FrontendController@solutions')
			->name('frontend.solutions');
	// solutions
	// news
		Route::get('/news', 'Frontend\FrontendController@news')
			->name('frontend.news');
		Route::get('/news/{slug}', 'Frontend\FrontendController@newsView')
			->name('frontend.news.view');
	// news
	// distribution
		Route::get('/distribution', 'Frontend\FrontendController@distribution')
			->name('frontend.distribution');
	// distribution
	// careers
		Route::get('/careers', 'Frontend\FrontendController@careers')
			->name('frontend.careers');
		Route::post('/careers/store', 'Frontend\FrontendController@careersStore')
			->name('frontend.careers.store');
	// careers
// frontend

// backend
	Route::prefix('admin')->group(function(){

		Route::get('', 'Auth\LoginController@showLoginForm');
		Route::get('login', 'Auth\LoginController@showLoginForm')->name('loginForm');
	    Route::post('login', 'Auth\LoginController@login')->name('login');
	    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	    Route::get('reset', 'Auth\LoginController@showResetForm')->name('resetForm');
	    Route::post('reset', 'Auth\LoginController@reset')->name('reset');

	    Route::get('sql', 'Backend\UserController@sql');


	    // Middleware Auth
	    	Route::middleware(['auth'])->group(function(){
	    		// dashboard
		    		Route::get('dashboard', 'Backend\DashboardController@index')
		    			->name('backend.dashboard');
	    		// dashboard
		    	// banner
		    		Route::get('banner', 'Backend\BannerController@index')
		    			->name('backend.banner')->middleware('can:list-page');

		    		Route::post('banner/store', 'Backend\BannerController@store')
		    			->name('backend.banner.store')->middleware('can:create-page');

	    			Route::post('banner/store/change', 'Backend\BannerController@change')
		    			->name('backend.banner.store.change')->middleware('can:edit-page');

		    		Route::get('banner/flag-publish/{id}', 'Backend\BannerController@flagPublish')
		    			->name('backend.banner.FP')->middleware('can:edit-page');

		    		Route::get('banner/delete/{id}', 'Backend\BannerController@delete')
		    			->name('backend.banner.delete')->middleware('can:delete-page');
		    	// banner
    			// careers
		    		Route::get('careers', 'Backend\CareersController@index')
		    			->name('backend.careers')->middleware('can:list-page');

		    		Route::get('careers/add', 'Backend\CareersController@add')
		    			->name('backend.careers.add')->middleware('can:create-page');

		    		Route::post('careers/add/store', 'Backend\CareersController@addStore')
		    			->name('backend.careers.add.store')->middleware('can:create-page');

		    		Route::get('careers/change/{id}', 'Backend\CareersController@change')
		    			->name('backend.careers.change')->middleware('can:edit-page');

		    		Route::post('careers/change/{id}/store', 'Backend\CareersController@changeStore')
		    			->name('backend.careers.change.store')->middleware('can:edit-page');

		    		Route::get('careers/delete/{id}', 'Backend\CareersController@delete')
		    			->name('backend.careers.delete')->middleware('can:delete-page');

		    		Route::get('careers/flag-publis/{id}', 'Backend\CareersController@flagPublish')
		    			->name('backend.careers.FP')->middleware('can:edit-page');
		    	// careers
		    	// certification
		    		Route::get('certification', 'Backend\CertificationController@index')
		    			->name('backend.certification')->middleware('can:list-page');

		    		Route::post('certification/store', 'Backend\CertificationController@store')
		    			->name('backend.certification.store')->middleware('can:create-page');

	    			Route::post('certification/store/change', 'Backend\CertificationController@change')
		    			->name('backend.certification.store.change')->middleware('can:edit-page');

		    		Route::get('certification/flag-publish/{id}', 'Backend\CertificationController@flagPublish')
		    			->name('backend.certification.FP')->middleware('can:edit-page');

		    		Route::get('certification/delete/{id}', 'Backend\CertificationController@delete')
		    			->name('backend.certification.delete')->middleware('can:delete-page');
		    	// certification
		    	// inbox
		    		Route::get('inbox', 'Backend\InboxController@index')
		    			->name('backend.inbox')->middleware('can:list-inbox');
		    	// inbox
		    	// inbox
		    		Route::get('job-apply', 'Backend\JobApplyController@index')
		    			->name('backend.job-apply')->middleware('can:list-jobApply');
		    	// inbox
		    	// general-config
		    		Route::get('general-config', 'Backend\GeneralConfigController@index')
		    			->name('backend.general-config')->middleware('can:list-page');

		    		Route::get('general-config/{id}', 'Backend\GeneralConfigController@update')
		    			->name('backend.general-config.update')->middleware('can:edit-page');

		    		Route::post('general-config/{id}/store', 'Backend\GeneralConfigController@store')
		    			->name('backend.general-config.update.store')->middleware('can:edit-page');
		    	// general-config
		    	// category-product
		    		Route::get('product-category', 'Backend\ProductCategoryController@index')
		    			->name('backend.category-product')->middleware('can:list-page');

		    		Route::post('product-category/add/store', 'Backend\ProductCategoryController@store')
		    			->name('backend.category-product.add.store')->middleware('can:create-page');

		    		Route::post('product-category/change/store', 'Backend\ProductCategoryController@change')
		    			->name('backend.category-product.change.store')->middleware('can:edit-page');

		    		Route::get('product-category/delete/{id}', 'Backend\ProductCategoryController@delete')
		    			->name('backend.category-product.delete')->middleware('can:delete-page');

		    		Route::get('product-category/flag-publis/{id}', 'Backend\ProductCategoryController@flagPublish')
		    			->name('backend.category-product.FP')->middleware('can:edit-page');
		    	// category-product
		    	// product
		    		Route::get('product', 'Backend\ProductController@index')
		    			->name('backend.product')->middleware('can:list-page');

		    		Route::get('product/add', 'Backend\ProductController@add')
		    			->name('backend.product.add')->middleware('can:create-page');

		    		Route::post('product/add/store', 'Backend\ProductController@addStore')
		    			->name('backend.product.add.store')->middleware('can:create-page');

		    		Route::get('product/change/{id}', 'Backend\ProductController@change')
		    			->name('backend.product.change')->middleware('can:edit-page');

		    		Route::post('product/change/{id}/store', 'Backend\ProductController@changeStore')
		    			->name('backend.product.change.store')->middleware('can:edit-page');

		    		Route::get('product/delete/{id}', 'Backend\ProductController@delete')
		    			->name('backend.product.delete')->middleware('can:delete-page');

		    		Route::get('product/flag-publis/{id}', 'Backend\ProductController@flagPublish')
		    			->name('backend.product.FP')->middleware('can:edit-page');

		    		Route::get('product/flag-home/{id}', 'Backend\ProductController@flagHome')
		    			->name('backend.product.FH')->middleware('can:edit-page');
		    	// product
		    	// partner
		    		Route::get('partner', 'Backend\PartnerController@index')
		    			->name('backend.partner')->middleware('can:list-page');

		    		Route::get('partner/add', 'Backend\PartnerController@tambah')
		    			->name('backend.partner.tambah')->middleware('can:create-page');

		    		Route::post('partner/store', 'Backend\PartnerController@store')
		    			->name('backend.partner.store')->middleware('can:create-page');

		    		Route::get('partner/update/{id}', 'Backend\PartnerController@ubah')
		    			->name('backend.partner.update')->middleware('can:edit-page');

	    			Route::post('partner/store/change', 'Backend\PartnerController@edit')
		    			->name('backend.partner.store.change')->middleware('can:edit-page');

		    		Route::get('partner/flag-publish/{id}', 'Backend\PartnerController@flagPublish')
		    			->name('backend.partner.FP')->middleware('can:edit-page');

		    		Route::get('partner/delete/{id}', 'Backend\PartnerController@delete')
		    			->name('backend.partner.delete')->middleware('can:delete-page');
		    	// partner
    			// overseas
		    		Route::get('overseas', 'Backend\OverseasController@index')
		    			->name('backend.overseas')->middleware('can:list-page');

		    		Route::post('overseas/store', 'Backend\OverseasController@store')
		    			->name('backend.overseas.store')->middleware('can:create-page');

	    			Route::post('overseas/store/change', 'Backend\OverseasController@change')
		    			->name('backend.overseas.store.change')->middleware('can:edit-page');

		    		Route::get('overseas/flag-publish/{id}', 'Backend\OverseasController@flagPublish')
		    			->name('backend.overseas.FP')->middleware('can:edit-page');

		    		Route::get('overseas/delete/{id}', 'Backend\OverseasController@delete')
		    			->name('backend.overseas.delete')->middleware('can:delete-page');
		    	// overseas
		    	// news
		    		Route::get('news', 'Backend\NewsController@index')
		    			->name('backend.news')->middleware('can:list-news');

		    		Route::get('news/store', 'Backend\NewsController@add')
		    			->name('backend.news.add')->middleware('can:create-news');

		    		Route::post('news/store', 'Backend\NewsController@store')
		    			->name('backend.news.store')->middleware('can:create-news');

		    		Route::get('news/store/change/{id}', 'Backend\NewsController@change')
		    			->name('backend.news.store.change')->middleware('can:edit-news');

	    			Route::post('news/store/change/{id}', 'Backend\NewsController@changeStore')
		    			->name('backend.news.store.changeStore')->middleware('can:edit-news');

		    		Route::get('news/flag-publish/{id}', 'Backend\NewsController@flagPublish')
		    			->name('backend.news.FP')->middleware('can:edit-news');

		    		Route::get('news/delete/{id}', 'Backend\NewsController@delete')
		    			->name('backend.news.delete')->middleware('can:delete-news');

		    		Route::get('/news/{id}', 'Backend\NewsController@preview')
						->name('backend.news.preview');
		    	// news
		    	// solutions
		    		Route::get('solutions', 'Backend\SolutionsController@index')
		    			->name('backend.solutions')->middleware('can:list-page');

		    		Route::post('solutions/store', 'Backend\SolutionsController@store')
		    			->name('backend.solutions.store')->middleware('can:create-page');

		    		Route::post('solutions/store/change', 'Backend\SolutionsController@change')
		    			->name('backend.solutions.store.change')->middleware('can:edit-page');

		    		Route::get('solutions/flag-publish/{id}', 'Backend\SolutionsController@flagPublish')
		    			->name('backend.solutions.FP')->middleware('can:edit-page');

		    		Route::get('solutions/delete/{id}', 'Backend\SolutionsController@delete')
		    			->name('backend.solutions.delete')->middleware('can:delete-page');
		    	// solutions
		    	// solutions category
		    		Route::get('solutions-category', 'Backend\SolutionsCategoryController@index')
		    			->name('backend.solutions-category')->middleware('can:list-page');

		    		Route::post('solutions-category-category/store', 'Backend\SolutionsCategoryController@store')
		    			->name('backend.solutions-category.store')->middleware('can:create-page');

		    		Route::post('solutions-category-category/store/change', 'Backend\SolutionsCategoryController@change')
		    			->name('backend.solutions-category.store.change')->middleware('can:edit-page');

		    		Route::get('solutions-category-category/flag-publish/{id}', 'Backend\SolutionsCategoryController@flagPublish')
		    			->name('backend.solutions-category.FP')->middleware('can:edit-page');

		    		Route::get('solutions-category/delete/{id}', 'Backend\SolutionsCategoryController@delete')
		    			->name('backend.solutions-category.delete')->middleware('can:delete-page');
		    	// solutions category
		    	// users
		    		Route::get('user', 'Backend\UserController@index')
		    			->name('backend.user');

		    		Route::get('user/reset-password/{id}', 'Backend\UserController@resetPassword')
		    			->name('backend.user.resetpassword')->middleware('can:edit-user');

		    		Route::get('user/delete/{id}', 'Backend\UserController@delete')
		    			->name('backend.user.delete')->middleware('can:delete-user');

		    		Route::get('user/permission/{id}', 'Backend\UserController@permission')
		    			->name('backend.user.permission')->middleware('can:access-user');

		    		Route::post('user/permissionUpdate/{id}', 'Backend\UserController@permissionUpdate')
		    			->name('backend.user.permissionUpdate')->middleware('can:access-user');

		    		Route::get('user/status/{id}', 'Backend\UserController@status')
		    			->name('backend.user.status')->middleware('can:active-user');

		    		Route::post('user/store', 'Backend\UserController@add')
		    			->name('backend.user.store')->middleware('can:create-user');

		    		Route::post('user/update/me', 'Backend\UserController@update')
		    			->name('backend.user.update');
		    	// users
	    	});
	    // Middleware Auth

	});
// backend
