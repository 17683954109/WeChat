<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Main;
use App\Entity\clas;
use App\Entity\product;
use App\Entity\pre_img;
use App\Entity\detail;
use App\Entity\cart;

class Goods extends Controller
{
//    首页商品列表方法
    public function index(){
        $res=product::all();
        $preimg=product::orderBy('id','desc')->limit(4)->get();
        $img=array();
        $ids=array();
        foreach ($preimg as $k=>$v){
            $img[]=$v->prview_img;
            $ids[]=$v->id;
        }
        return view('prolist',['res'=>$res,'preimg'=>$img,'id'=>$ids]);
    }
    //一级商品分类ajax访问方法
    public function clas(){
        $main=Main::select('*')->get();
        return $main;
    }


    // 二级分类ajax访问方法
    public function det(){
        $id=$_GET['id'];
        $res=clas::where('main_class',$id)->get();
        return $res;
    }


    // 分类商品列表ajax访问方法
    public function product($id){
        $res=product::select('*')->where('class_id',$id)->get();
        $imgs=pre_img::select('address')->get();
//        return view('product',['res'=>$res]);
        return response()->json($res,200);
    }

    // 商品详情访问方法
    public function pro($id){
        $res=product::select('*')->where('id',$id)->first();
        $ress=product::where('id',$id)->first();
        $imgid=$ress->class_id;
        $detail=detail::select('*')->where('detail_id',$id)->first();
        $preimg=pre_img::select('*')->where('detail_id',$id)->get();
        return view('product',['res'=>$res,'preimg'=>$preimg,'det'=>$detail]);
    }
    
//    添加到购物车方法
    public function addcart(Request $request,$id,$num){
        $cart=$request->cookie('cart');
        $count=$num;
//        if (session('user')!=null&&session('user')!=''){
            $cartdbs=cart::where('user',session('user'))->first();
//        }
        if ($cartdbs!=null){
            $cart=$cartdbs->proinfo;
        }
        $cart_arr=$cart!=null ? explode(',', $cart) : array();
            foreach ($cart_arr as &$value) {
                $index = strpos($value, ':');
                if (substr($value, 0, $index) == $id) {
                    $count = ((int) substr($value, $index+1)) + $num;
                    $value = $id.':'.$count;
                    break;
                }
            }
            if ($count==$num){
            array_push($cart_arr,$id.":".$count);
            }
            $carts=implode(',',$cart_arr);
            if (session('user')!=null&&session('user')!=''){
                $cartdb=cart::select('*')->where('user',session('user'))->first();
                if ($cartdb==null){
                    $cartdb=new cart;
                    $cartdb->user=session('user');
                }
                $cartdb->proinfo=$carts;
                $cartdb->save();
            }
            if (session('user')!=null&&session('user')!=''){
                return response()->json('ok',200);
            }
        return response()->json('ok',200)->withCookie('cart',$carts);
    }
    public function changeCart(Request $request,$id,$num){
        $cart=$request->cookie('cart');
        $count=$num;
//        if (session('user')!=null&&session('user')!=''){
        $cartdbs=cart::select('proinfo')->where('user',session('user'))->first();
//        }
        if ($cartdbs!=null){
            $cart=$cartdbs->proinfo;
        }
        $cart_arr=$cart!=null ? explode(',', $cart) : array();
        foreach ($cart_arr as &$value) {
            $index = strpos($value, ':');
            if (substr($value, 0, $index) == $id) {
                $count =$num;
                $value = $id.':'.$count;
                break;
            }
        }
        $carts=implode(',',$cart_arr);
        if (session('user')!=null&&session('user')!=''){
            $cartdb=cart::select('*')->where('user',session('user'))->first();
            if ($cartdb==null){
                $cartdb=new cart;
                $cartdb->user=session('user');
            }
            $cartdb->proinfo=$carts;
            $cartdb->save();
        }
        if (session('user')!=null&&session('user')!=''){
            return response()->json('ok',200);
        }
        return response()->json('ok',200)->withCookie('cart',$carts);
    }
    public function getprice($proids){
        $res_arr=explode(',',$proids);
        $total=0;
        $pro=cart::where('user',session('user'))->first();
        $pro_arr=explode(',',$pro->proinfo);
        foreach ($res_arr as $value) {
                foreach ($pro_arr as $k => $v) {
                    $index=strpos($v,':');
                    $id=substr($v,0,$index);
                    $count=substr($v,$index+1);
                    if ($id==$value) {
                       $totnum=product::select('price')->where('id',$id)->first();
                        $total+=($totnum->price)*$count;
                    }
                }
                
        }
        return response()->json($total,200);
    }
}
