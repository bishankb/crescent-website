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

Route::group([
    'namespace' => 'Backend',
    'prefix' => 'admin',
    'middleware' => ['auth']
], function(){
    Route::get('/', 'DashboardController@index');
    Route::resource('/users', 'UserController');
    Route::post('/users/edit-profile/{id}', 'UserController@editProfile')->name('users.editProfile');
    Route::post('/users/change-password/{id}', 'UserController@changePassword')->name('users.changePassword');
    Route::post('/users/change-status/{id}', 'UserController@changeStatus')->name('users.changeStatus');
    Route::post('/users/restore/{id}', 'UserController@restore')->name('users.restore');
    Route::delete('/users/force-delete/{id}', 'UserController@forceDestroy')->name('users.forceDestroy');
    Route::post('/users/delete-image/{id}', 'UserController@destroyImage')->name('users.destroyImage');

    Route::group([
    'namespace' => 'Blog'
    ], function(){
    
        Route::resource('categories', 'CategoryController');
        Route::post('/categories/change-status/{id}', 'CategoryController@changeStatus')->name('categories.changeStatus');
        Route::post('/categories/restore/{id}', 'CategoryController@restore')->name('categories.restore');
        Route::delete('/categories/force-delete/{id}', 'CategoryController@forceDestroy')->name('categories.forceDestroy');

        Route::resource('tags', 'TagController');
        Route::post('/tags/change-status/{id}', 'TagController@changeStatus')->name('tags.changeStatus');
        Route::post('/tags/restore/{id}', 'TagController@restore')->name('tags.restore');
        Route::delete('/tags/force-delete/{id}', 'TagController@forceDestroy')->name('tags.forceDestroy');

        Route::resource('blogs', 'BlogController');
        Route::post('/blogs/change-status/{id}', 'BlogController@changeStatus')->name('blogs.changeStatus');
        Route::post('/blogs/restore/{id}', 'BlogController@restore')->name('blogs.restore');
        Route::delete('/blogs/force-delete/{id}', 'BlogController@forceDestroy')->name('blogs.forceDestroy');
        Route::post('/blogs/delete-image/{id}', 'BlogController@destroyImage')->name('blogs.destroyImage');
    });

    Route::resource('features', 'FeatureController');
    Route::post('/features/change-status/{id}', 'FeatureController@changeStatus')->name('features.changeStatus');
    Route::post('/features/restore/{id}', 'FeatureController@restore')->name('features.restore');
    Route::delete('/features/force-delete/{id}', 'FeatureController@forceDestroy')->name('features.forceDestroy');

    Route::resource('products', 'ProductController');
    Route::post('/products/change-status/{id}', 'ProductController@changeStatus')->name('products.changeStatus');
    Route::post('/products/restore/{id}', 'ProductController@restore')->name('products.restore');
    Route::delete('/products/force-delete/{id}', 'ProductController@forceDestroy')->name('products.forceDestroy');
    Route::post('/products/delete-image/{id}', 'ProductController@destroyImage')->name('products.destroyImage');

    Route::resource('services', 'ServiceController');
    Route::post('/services/change-status/{id}', 'ServiceController@changeStatus')->name('services.changeStatus');
    Route::post('/services/restore/{id}', 'ServiceController@restore')->name('services.restore');
    Route::delete('/services/force-delete/{id}', 'ServiceController@forceDestroy')->name('services.forceDestroy');
    Route::post('/services/delete-image/{id}', 'ServiceController@destroyImage')->name('services.destroyImage');

    Route::get('/contact-us/edit', 'ContactUsController@edit')->name('contact-us.edit');
    Route::post('/contact-us/update', 'ContactUsController@update')->name('contact-us.update');

    Route::resource('roles', 'RoleController');

    Route::get('mark-as-read', 'ViewerMessageController@markAsRead')->name('viewer-messages.markAsRead');

    Route::resource('bulksms', 'BulkSmsController');
    Route::post('/bulksms/mass-destory', 'BulkSmsController@massDestroy')->name('bulksms.massDestroy');
    Route::post('/bulksms/mass-send-message', 'BulkSmsController@massSendMessage')->name('bulksms.massSendMessage');

    Route::resource('phonebooks', 'PhoneBookController');
    Route::post('/phonebooks/restore/{id}', 'PhoneBookController@restore')->name('phonebooks.restore');
    Route::delete('/phonebooks/force-delete/{id}', 'PhoneBookController@forceDestroy')->name('phonebooks.forceDestroy');
});

Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::post('/login','Auth\LoginController@login');
Route::post('/logout','Auth\LoginController@logout')->name('logout');


Route::group([
    'namespace' => 'Frontend',
], function(){
    Route::get('/', 'HomeController@index')->name('frontend.home');
    Route::get('/about', 'AboutController@index')->name('frontend.about');
    Route::get('/services', 'ServiceController@index')->name('frontend.service');
    Route::get('/blogs', 'BlogController@index')->name('frontend.blog');
    Route::get('/blogs/{blog}', 'BlogController@show')->name('frontend.blog.show');
    Route::get('/blogs/category/{slug}', 'BlogController@categoryBlogs')->name('frontend.blog.category');
    Route::get('/blogs/tag/{slug}', 'BlogController@tagBlogs')->name('frontend.blog.tag');
    Route::get('/contact-us', 'ContactUsController@index')->name('frontend.contact-us');
    Route::get('/product/{product}', 'ProductController@show')->name('frontend.product.show');
});
Route::post('/viewer-message/send', 'Backend\ViewerMessageController@send')->name('viewer-messages.send');
	