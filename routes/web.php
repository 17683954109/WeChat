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
use App\Entity\admin;
Route::get('/', function (\Illuminate\Http\Request $request) {
    $return_url=$request->input('return_url','');
    return view('login')->with('return_url',urldecode($return_url));
});
Route::get('/register',function (){
    return view('register');
});
Route::get('/qrcode',function(){
	return view('qrcode');
});
Route::get('/login',function (\Illuminate\Http\Request $request){
    $return_url=$request->input('return_url','');
    return view('login')->with('return_url',urldecode($return_url));
});

//登录注册路由组

//    用户注册路由

    Route::post('/login/adduser/{mode}','userService@reg');

//    获取手机验证码路由

    Route::post('/login/getSmsCode','userService@getSmsCode');

//    邮箱链接注册激活路由

    Route::get('/login/{email}/{code}','userService@getlogup');

//    用户登录路由

    Route::post('/login/login','userService@login');

// 商品路由

    Route::get('/goods', function(){
        return view('categary');
    });

//    商品一级分类api接口路由

    Route::get('/goods/class','Goods@clas');

//    商品二级分类api接口路由

    Route::get('/goods/clas','Goods@det');
    Route::get('/goods/product/{id}','Goods@product');
    Route::get('/product/{id}','Goods@pro');
    Route::get('/cart/add/{id}/{num}','Goods@addcart');

//    需要登录才能访问的路由组

    Route::group(['middleware'=>'login'],function(){
        Route::get('/cart/pay/{id}/{num}','cart@pay');
        Route::get('/cart/vis','cart@visit');
        Route::get('/cart/delcart','cart@delcart');
        Route::get('/cart/change/{id}/{num}','Goods@changeCart');
        Route::get('/cart/order/{product_ids}','cart@order');
        Route::get('/cart/getprice/{proids}','Goods@getprice');
        Route::get('/cart/order_list','cart@orderlist');
        Route::get('/order/{order_id}','cart@orderdetail');
        Route::get('/delorder/{order_id}','cart@delorder');
        
    });

    //后台路由组
    Route::group(['middleware'=>'admins'],function(){
        Route::get('/admin/index',function(){
            return view('admin.index');
        });
        Route::get('/admin/welcome',function(){
            return view('admin.welcome');
        });
    });
        Route::get('/admin/login',function(){
            return view('admin.login');
        });
        Route::get('/admin/img_list','admin@img_list');
        Route::post('/admin/login/log','admin@login');
        Route::get('/admin/member-list','admin@memberlist');
        Route::get('/admin/picture-show','admin@img_show');

