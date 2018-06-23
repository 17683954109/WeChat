<?php

namespace App\Http\Controllers;
use App\Entity\product;
use Illuminate\Http\Request;
use App\Entity\cart as carts;
use App\Entity\pre_img;
use Illuminate\Support\Facades\Cookie;
use App\Entity\order;
use App\Entity\order_shutcut;


class cart extends Controller
{
    // 商品立即购买方法
    public function pay($id,$num){
        $price=product::select('*')->where('id',$id)->first();
        $totalprice=$price->price*$num;
        return view('pay',['price'=>$price,'total'=>$totalprice,'num'=>$num,'user'=>session('user')]);
    }

    // 购物车查看方法
    public function visit(Request $request){

//        尝试从数据库读取用户的购物车信息
        $cart=carts::where('user',session('user'))->first();
//        创建存储各个商品数据的数组
        $cart_arr=array();
        $proimg=array();
        $cartprc=array();
        $count=array();
        $proid=array();
        $prctotal=array();
//        取出cookie中的购物车信息
        $ckcart=Cookie::get('cart');
//        如果用户数据库中没有商品而且cookie中也没有购物车信息，就直接返回视图
        if (!isset($cart->proinfo)&&$ckcart==null){
            return view('cart',['cart'=>null,'img'=>null,'price'=>null,'num'=>null,'id'=>null,'prctotal'=>null]);
        }
//        如果用户数据库中有记录，但信息为空，就直接返回视图
        if ($cart->proinfo==''&&$ckcart==null){
            return view('cart',['cart'=>null,'img'=>null,'price'=>null,'num'=>null,'id'=>null,'prctotal'=>null]);
        }
        $ckcart_arr=($ckcart!=null ? explode(',',$ckcart) : '');
//        如果说用户的数据库中有数据，就将数据库中的数据作为主要数据来源，并将其转换为数组
        if (isset($cart->proinfo)&&$cart->proinfo!=''){
            $cart_arrs=explode(',',$cart->proinfo);
            if ($ckcart_arr!=''&&$ckcart_arr!=''){
                    foreach ($ckcart_arr as &$ck) {
                        $indexs = strpos($ck, ':');
                        $ids = substr($ck, 0, $indexs);
                        $cots = (int)substr($ck, $indexs + 1);
                        foreach ($cart_arrs as &$cartsss) {
                            $index = strpos($cartsss, ':');
                            $id = substr($cartsss, 0, $index);
                            $cot = (int)substr($cartsss, $index + 1);
                            if ($id == $ids) {  //  如果说cookie 中的商品id 和数据库中的商品id 相同，就将数量相加
                                $numsss = $cot + $cots;
                                $cartsss = $id.':'.$numsss;
//                                让相同的数据记录变为字符串ss，方便下面取出不同的数据进行合并
                                $ck='ss';
                            }
                        }
                    }
//                    值为ss  的是上面剔除掉的相同的商品id，剩下的即为新增的，将其push入下面进行取商品信息的数组
                    foreach ($ckcart_arr as $cs){
                    if ($cs!='ss'){
                        array_push($cart_arrs,$cs);
                    }
                }
            }
            $ckcart_arr=$cart_arrs;

        }
//      从数据库读取各种信息
        foreach ($ckcart_arr as $key=>$value){
            $index=strpos($value,':');
            $id=substr($value,0,$index);
            $prnum=(int) substr($value,$index+1);
            $count[]=(int) substr($value,$index+1);
            $cart_arr[]=product::select('info')->where('id',$id)->first();
            $proid[]=$id;
            $proimg[]=pre_img::select('address')->where('id',$id)->first();
            $cartprc[]=product::select('price')->where('id',$id)->first();
            $prctotal[]=$cartprc[$key]->price*$prnum;
        }
//        将新的购物车数组重新转换为字符串
        $ckcartss=implode(',',$ckcart_arr);
//        如果之前从数据库中取出了数据，就更新原有数据，如果没有，就新建一条用户购物车记录
        if ($cart==null){
           $cart=new carts;
           $cart->user=session('user');
           $cart->proinfo=$ckcartss;
        }else{
            $cart->proinfo=$ckcartss;
        }
        $cart->save();
//        购物车信息已保存到数据库，清空cookie，防止出现数量翻倍的情况
        Cookie::queue(Cookie::forget('cart'));
//        显示视图，并传递视图需要用到的数据
        return view('cart',['cart'=>$cart_arr,'img'=>$proimg,'price'=>$cartprc,'num'=>$count,'id'=>$proid,'prctotal'=>$prctotal]);
    }

    // 购物车删除商品方法，参数为商品id
    public function delcart(Request $request){
        // 获取传递的商品id
        $products=$request->input('products','');
        // 判断是否出现了空的商品id
        if ($products==''){
            return response()->json('nothing to del',200);
        }
        // 取出其中的商品id，并用数组保存
        $products_arr=explode(',',$products);
        // 将用户的购物车调出，方便后续删除
        $cart_arr=carts::select('*')->where('user',session('user'))->first();
        $cart_arr=explode(',',$cart_arr->proinfo);
        // 将id相同的商品记录删除
        foreach ($cart_arr as $k => $val) {
            $indexss = strpos($val, ':');
            $proid=substr($val,0,$indexss);
            if(in_array($proid,$products_arr)){
                unset($cart_arr[$k]);
            }
        }
        // 拼合数组，生成新的购物车记录
        $carts=implode(',',$cart_arr);
        $cartdb=carts::where('user',session('user'))->first();
        // 与数据库进行同步
        if ($cartdb!=null){
            if ($carts==''){
                $cartdb->proinfo='';
            }else{
                $cartdb->proinfo=$carts;
            }
            $cartdb->save();
        }
        // 返回操作结果，方法结束
            return response()->json('ok',200);
    }


    // 生成订单方法，参数为商品id
    public function order($product_ids){
        // 生成订单号
        $order_date = date('Y-m-d');
 
          //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
         
        $order_id_main = date('YmdHis') . rand(10000000,99999999);
         
        //订单号码主体长度
         
        $order_id_len = strlen($order_id_main);
         
        $order_id_sum = 0;
         
        for($i=0; $i<$order_id_len; $i++){
         
        $order_id_sum += (int)(substr($order_id_main,$i,1));
         
        }
         
          //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
         
        $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);
        // 提取所有的要购买的商品，并保存为数组
        $res_arr=explode(',',$product_ids);
        // 提取用户中的购物车信息
        $cart_inf=carts::where('user',session('user'))->first();
        $cart_info=explode(',',$cart_inf->proinfo);
        // 将数据库需要的字段进行创建
        $product=array();
        $nums=array();
        $order_arr=array();
        $price=array();
        $totalprice=0;
        // 将提交过来的商品从购物车移除
        foreach ($cart_info as $key => $value) {
           $index=strpos($value,':');
           $idinfo=substr($value,0,$index);
           foreach ($res_arr as $k => $v) {
               if ($idinfo==$v) {
               $nums[$k]=substr($value,$index+1);
               $order_arr[]=$v.':'.$nums[$k];
               $product[$k]=product::where('id',$idinfo)->first();
               $price[]=$v.':'.$product[$k]->price;
               $totalprice+=$product[$k]->price*$nums[$k];
               unset($cart_info[$key]);
               }
           }
           }
           // 拼合数组，准备存入数据库
         $proinfo=implode(',',$order_arr);
         $price=implode(',',$price); 
          //进行数据库写入操作 
        $order=new order;
        $order->order_id=$order_id;
        $order->state='no pay';
        $order->user=session('user');
        $order->proinfo=$proinfo;
        $order->save();
        $order_shutcut=new order_shutcut;
         $order_shutcut->order_id=$order_id;
         $order_shutcut->price=$price;
         $order_shutcut->save();
         // 数据库订单生成完成，购物车进行同步
         $cart_info=implode(',',$cart_info);
        $cart_inf->proinfo=$cart_info;
        $cart_inf->save();
          // 返回视图，方法结束
        return view('order',['pro'=>$product,'num'=>$nums,'total'=>$totalprice]);
    }

    // 获取用户订单列表方法
    public function orderlist(){
        // 获取用户的session用户名
        $user=session('user');
        // 根据用户名提取订单
        $orderlist=order::where('user',$user)->get();
        $orderlist=json_decode($orderlist);
        $orderid_arr=array();
        $state_arr=array();
        $create_arr=array();
        $product=array();
        $pro_arr=array();
        $count=array();
        $product_arr=array();
        // 获取并生成需要的信息
        foreach ($orderlist as $key => $value) {
            $pro_arr[]=explode(',',$value->proinfo);
           $orderid_arr[]=$value->order_id;
           $state_arr[]=$value->state;
           $create_arr[]=$value->created_at;
        }
        $total=array();
        foreach ($pro_arr as $kk=>$pro){
            $total[$kk]=0;
        foreach ($pro as $k => $v){
            $index=strpos($v,':');
            $id=substr($v,0,$index);
            $product_arr[$kk][$k]=product::where('id',$id)->first();
            $count[$kk][$k]=substr($v,$index+1);
            $total[$kk]+=($product_arr[$kk][$k]->price)*$count[$kk][$k];
        }}
        // 返回视图并传递视图层需要的数据
        return view('order_list',[
            'orderid'=>$orderid_arr,
            'state'=>$state_arr,
            'created'=>$create_arr,
            'product'=>$product_arr,
            'count'=>$count,
            'total'=>$total
        ]);
    }

    // 订单详情方法，参数为订单id
    public function orderdetail($order_id){
        // 从数据库中读取价格和商品信息快照
        $order_res=order::where('order_id',$order_id)->first();
        $state=$order_res->state;
        $price_res=order_shutcut::where('order_id',$order_id)->first();
        $prc_arr=explode(',',$price_res->price);
        $pro_arr=explode(',',$order_res->proinfo);
        // 创建需要读取的商品信息数组
        $img=array();
        $prc=array();
        $nums=array();
        $info=array();
        $total=0;
        $pro_ids=array();
        // 获取并生成需要的信息
        foreach ($pro_arr as $key => $value) {
           $index=strpos($value,':');
           $id=substr($value,0,$index);
           $count=substr($value,$index+1);
           foreach ($prc_arr as $k => $val) {
           $indexs=strpos($val,':');
           $ids=substr($val,0,$indexs);
           $price=substr($val,$indexs+1);
           if ($id==$ids) {
               $pro=product::where('id',$id)->first();
               $img[]=$pro->prview_img;
               $prc[]=$price;
               $nums[]=$count;
               $info[]=$pro->info;
               $total+=$price*$count;
               $pro_ids[]=$id;
               break;
           }
           }
        }
        // 返回用户视图并传递视图层需要的所有数据,方法结束
        return view('order_detail',[
            'image'=>$img,
            'price'=>$prc,
            'nums'=>$nums,
            'title'=>$info,
            'order_id'=>$order_id,
            'state'=>$state,
            'total'=>$total,
            'proid'=>$pro_ids
        ]);
    }
    public function delorder($order_id){
        order::where('order_id',$order_id)->first()->delete();
        order_shutcut::where('order_id',$order_id)->first()->delete();
        return response()->json('ok',200);
    }
}
