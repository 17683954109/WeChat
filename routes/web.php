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

//      网站首页路由
Route::get('/', function (\Illuminate\Http\Request $request) {
    $return_url=$request->input('return_url','');
    return view('login')->with('return_url',urldecode($return_url));
});
//      网站注册路由
Route::get('/register',function (){
    return view('register');
});
//      图形验证码路由
Route::get('/qrcode',function(){
	return view('qrcode');
});
//      用户登录路由
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

//    分类下的商品简略信息显示路由
    Route::get('/goods/product/{id}','Goods@product');

//    商品详情页显示路由
    Route::get('/product/{id}','Goods@pro');

//    添加到购物车ajax路由
    Route::get('/cart/add/{id}/{num}','Goods@addcart');

//    需要登录才能访问的路由组

    Route::group(['middleware'=>'login'],function(){

//        产品页立即购买路由
        Route::get('/cart/pay/{id}/{num}','cart@pay');

//        购物车查看路由
        Route::get('/cart/vis','cart@visit');

//        购物车删除路由
        Route::get('/cart/delcart','cart@delcart');

//        购物车商品编辑路由
        Route::get('/cart/change/{id}/{num}','Goods@changeCart');

//        订单生成路由
        Route::get('/cart/order/{product_ids}','cart@order');

//        购物车页获取商品总价格路由
        Route::get('/cart/getprice/{proids}','Goods@getprice');

//        订单列表查看路由
        Route::get('/cart/order_list','cart@orderlist');

//        订单详情查看路由
        Route::get('/order/{order_id}','cart@orderdetail');

//        订单删除ajax路由
        Route::get('/delorder/{order_id}','cart@delorder');
        
    });

    //后台路由组
    Route::group(['middleware'=>'admins'],function(){

//        后台首页路由
        Route::get('/admin/index',function(){
            return view('admin.index');
        });

//        后台首页服务器信息路由
        Route::get('/admin/welcome',function(){
            return view('admin.welcome');
        });

//        会员列表路由
        Route::get('/admin/member-list','admin@memberlist');

//        图片显示路由
        Route::get('/admin/picture-show/{id}','admin@img_show');

//        图片添加页面显示路由
        Route::get('/admin/picture-add','admin@addimg');

//        图片上传路由
        Route::POST('/admin/imgadd','admin@imgupload');

//        图片删除路由
        Route::get('/admin/imgdel','admin@imgdel');

//        商品编辑页显示路由
        Route::get('/admin/productEdit/{id}','admin@proEdit');

//        商品编辑ajax路由
        Route::post('/admin/prochange','admin@prochange');

//        商品删除ajax路由
        Route::get('/admin/prodel/{id}','admin@prodel');

//        实时获取服务器时间ajax路由
        Route::get('/admin/gettime','admin@gettime');

//        添加商品页显示路由
        Route::get('/admin/proadd','admin@proadd');

//        商品列表页显示路由
        Route::get('/admin/img_list','admin@img_list');

//        添加商品临时图片ajax路由
        Route::get('/admin/tmpimg/{id}','admin@tmpimg');

//        商品添加ajax路由
        Route::post('/admin/proreg','admin@proreg');

//        删除商品ajax路由
        Route::get('/admin/delpro','admin@delpro');

//        分类添加页显示路由
        Route::get('/admin/category','admin@category');

//        分类添加ajax路由
        Route::post('/admin/cateadd','admin@cateadd');

//        分类编辑页显示路由
        Route::get('/admin/catelist','admin@catelist');

//        分类列表主/子分类切换显示，ajax路由
        Route::get('/admin/show/{mode}','admin@shows');

//        分类删除ajax路由
        Route::get('/admin/catedel/{mode}','admin@catedel');

//        分类编辑详细页显示路由
        Route::get('/admin/cateEdit/{id}/{mode}','admin@cateEdit');

//        分类编辑ajax路由
        Route::post('/admin/cateChange','admin@cateChange');

//        订单管理页显示路由
        Route::get('/admin/orderlist','admin@orderlist');

//        订单详情页显示路由
        Route::get('/admin/orderinfo/{order_id}','admin@orderinfo');

//        订单发货ajax路由
        Route::get('/admin/orderchange','admin@orderchange');

//        订单删除ajax路由
        Route::post('/admin/order_del','admin@order_del');

//        管理员退出登录路由
        Route::get('/admin/logout','admin@logout');
    });
//        后台登录页显示路由
        Route::get('/admin/login',function(){
            return view('admin.login');
        });

//        后台登录ajax路由
        Route::post('/admin/login/log','admin@login');


