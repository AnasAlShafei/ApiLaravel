<?php

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

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//التسجيل في الموقع .

Route::group(['prefix' => 'auth', 'namespace' => 'Api\Auth'], function () {
    Route::post('register', 'RegisterController@register');
    Route::post('login/user', 'RegisterController@createUser');

});
/** الراوبط ...
 *
 * التسجيل في الموقع
 *  http://localhost:8000/api/auth/register
 * تسجيل الدخول
 * http://localhost:8000/oauth/token
 *
 * المنتجات
 * http://localhost:8000/api/products
 * إضافة منتج
 * http://localhost:8000/api/product/store
 * حذف منتج
 * http://localhost:8000/api/product/delete/1
 * عرض المنتجات المحذوفة
 * http://localhost:8000/api/product/trashed
 * حذف المنتج نهائياً
 * http://localhost:8000/api/product/drop/1
 * إعادة نشر المنتج
 * http://localhost:8000/api/product/restore/1
 * المنتجات المطلوبة من قبل اليوزرز
 * http://localhost:8000/api/product/byclints
 * تحديث المنتج
 * http://localhost:8000/api/product/update/1
 * عرض المنتج
 * http://localhost:8000/api/product/view/1
 *
 */
Route::group(['prefix' => 'product', 'middleware' => ['auth:api', 'admin']], function () {
    Route::post('/store', 'ProductsController@store');
    Route::post('/delete/{id}', 'ProductsController@delete');
    Route::post('/trashed', 'ProductsController@trashed');
    Route::delete('/drop/{id}', 'ProductsController@drop');
    Route::post('/restore/{id}', 'ProductsController@restore');
    Route::get('/show/{id}', 'ProductsController@show');
    Route::post('/update/{id}', 'ProductsController@update');
    Route::get('/byclints', 'ProductsController@byclints');
});

/**
 * إعدادات الأدمن
 * ...
 * عرض جميع المستخدمين
 * http://localhost:8000/api/showallusers
 * تحديث حالة المنتج
 * http://localhost:8000/api/orders/changestatus/1
 * جميع الطلبات
 * http://localhost:8000/api/orders/all
 * جميع الطالبات التي تم حذفها
 * http://localhost:8000/api/orders/trashed
 * اعادة طلب تم حذفه مسبقاً
 * http://localhost:8000/api/orders/restore/1
 * حذف طلب نهائياً
 * http://localhost:8000/api/orders/drop/1
 */
Route::middleware(['admin', 'auth:api'])->group(function () {
    Route::get('/showallusers', 'UsersController@showAllUsers');
    Route::post('orders/changestatus/{id}', 'OrdersController@changeStatusOrder');
    Route::get('orders/all', 'OrdersController@index');
    Route::get('orders/trashed', 'OrdersController@getAllTrashed');
    Route::post('orders/restore/{id}', 'OrdersController@restoreOrder');
    Route::delete('orders/drop/{id}', 'OrdersController@forcDeleteOrder');

});
/**
 * وابط خاصة بالأدمن والمستخدم
 *
 * جميع المنتجات
 * http://localhost:8000/api/products
 *
 * عرض تفاصيل الطلب
 * http://localhost:8000/api/orders/show/1
 *
 * حذف الطلب
 * http://localhost:8000/api/orders/delete/1
 */
Route::middleware('auth:api')->group(function () {

    Route::get('/products', 'ProductsController@index');
    Route::post('orders/delete/{id}', 'OrdersController@destroy');
    Route::get('orders/show/{id}', 'OrdersController@show');

});
/**
 * طلب منتج جديد من قبل الزبون
 * http://localhost:8000/api/newproductbyuser
 *
 * تحديث الطلب
 * http://localhost:8000/api/orders/update/1
 *
 * عرض جميع طلبات المستخدم
 * http://localhost:8000/api/orders/all
 *
 * طلب منتج جديد
 * http://localhost:8000/api/orders/storeorder
 *
 */
Route::middleware(['user', 'auth:api'])->group(function () {
    Route::post('product/byuser', 'ProductsController@newproductbyuser');
    Route::post('orders/update/{id}', 'OrdersController@update');
    Route::get('orders/all', 'OrdersController@all');
});
Route::any('/orders/new', 'OrdersController@newOrder');
