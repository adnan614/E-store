<?php



Route::get('/', function () {
        return view('pages.index');
});
//auth & user
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/password-change', 'HomeController@changePassword')->name('password.change');
Route::post('/password-update', 'HomeController@updatePassword')->name('password.update');
Route::get('/user/logout', 'HomeController@Logout')->name('user.logout');

//admin=======
Route::get('admin/home', 'AdminController@index');
Route::get('admin', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('admin', 'Admin\LoginController@login');
// Password Reset Routes...
Route::get('admin/password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin-password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/reset/password/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/update/reset', 'Admin\ResetPasswordController@reset')->name('admin.reset.update');
Route::get('/admin/Change/Password', 'AdminController@ChangePassword')->name('admin.password.change');
Route::post('/admin/password/update', 'AdminController@Update_pass')->name('admin.password.update');
Route::get('admin/logout', 'AdminController@logout')->name('admin.logout');


// admin section

Route::get('admin/categories', 'Admin\Category\CategoryController@category')->name('categories');
Route::post('admin/store/category', 'Admin\Category\CategoryController@storeCategory')->name('store.category');
Route::get('admin/delete/category/{id}', 'Admin\Category\CategoryController@deleteCategory')->name('delete.category');
Route::get('admin/edit/category/{id}', 'Admin\Category\CategoryController@editCategory')->name('edit.category');
Route::post('admin/update/category/{id}', 'Admin\Category\CategoryController@updateCategory')->name('update.category');

// brand section

Route::get('admin/brands', 'Admin\Brand\BrandController@brand')->name('brands');
Route::post('admin/store/brand', 'Admin\Brand\BrandController@storeBrand')->name('store.brand');
Route::get('admin/delete/brand/{id}', 'Admin\Brand\BrandController@deleteBrand')->name('delete.brand');
Route::get('admin/edit/brand/{id}', 'Admin\Brand\BrandController@editBrand')->name('edit.brand');
Route::post('admin/update/brand/{id}', 'Admin\Brand\BrandController@updateBrand')->name('update.brand');
