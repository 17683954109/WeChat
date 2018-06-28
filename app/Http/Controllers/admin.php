<?php

namespace App\Http\Controllers;
use App\Entity\admin as adm;
use Illuminate\Http\Request;
use App\Entity\pre_img;
use App\Entity\product;
use App\Entity\clas;
use App\Entity\User2;
use App\Entity\Main;
use App\Entity\detail;
use App\temp_img;
use App\Entity\order;
use App\Entity\order_shutcut;
use App\order_detail;

class admin extends Controller
{
//    管理员退出登录方法
    public function logout(){
        session(['adminuser'=>'']);
        return redirect('/admin/login');
    }
//    订单删除ajax方法
    public function order_del(Request $request){
        $oid=$request->input('id');
        if ($oid!=null&&$oid!=''){
            order::where('order_id',$oid)->first()->delete();
            order_shutcut::where('order_id',$oid)->first()->delete();
            return response()->json('ok',200);
        }
        return response()->json('error',200);
    }
//    订单发货ajax方法
    public function orderchange(){
        $order_id=session('order');
        if ($order_id!=null&&$order_id!=''){
            $od=order::where('order_id',$order_id)->first();
            $od->state='complate';
            $od->save();
            return response()->json('ok',200);
        }
        return response()->json('error',200);
    }

//      订单详情发货显示方法
    public function orderinfo($order_id){
        // 从数据库中读取价格和商品信息快照
        $order_res=order::where('order_id',$order_id)->first();
        $Collect=order_detail::where('id',$order_res->detail_id)->first();
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
        session(['order'=>$order_id]);  //  以session 方式存储订单id，防止订单id 被篡改
        // 返回用户视图并传递视图层需要的所有数据,方法结束
        return view('admin.order_detail',[
            'image'=>$img,
            'price'=>$prc,
            'nums'=>$nums,
            'title'=>$info,
            'order_id'=>$order_id,
            'state'=>$state,
            'total'=>$total,
            'proid'=>$pro_ids,
            'collect'=>$Collect
        ]);
    }

//    订单编辑页显示方法
    public function orderlist(){
        $res=order::orderBy('id','desc')->get();
        $order=array();
        foreach ($res as $k=>$v){
            $order[]=order_detail::where('id',$v->detail_id)->first();
        }
        return view('admin.orderlist',['res'=>$res,'info'=>$order]);
    }
//    分类编辑ajax方法
    public function cateChange(Request $request){
        $mode=$request->input('mode');
        $title=$request->input('title');
        $content=$request->input('content');
        $id=$request->input('id');
        if ($mode=='main'){
            $res=Main::where('class_id',$id)->first();
            $res->pro_name=$title;
            $res->preview=$content;
            $res->save();
            return response()->json('ok',200);
        }else{
            $res=clas::where('class_id',$id)->first();
            $res->class_name=$title;
            $res->preview=$content;
            $res->save();
            return response()->json('ok',200);
        }
        return response()->json('error',200);
    }
//    分类编辑方法
    public function cateEdit($id,$mode){
        if ($mode=='m'){
            $res=Main::where('class_id',$id)->first();
            return view('admin.cateEdit',['res'=>$res,'mode'=>'main']);
        }else{
            $res=clas::where('class_id',$id)->first();
            return view('admin.cateEdit',['res'=>$res,'mode'=>'clas']);
        }
        return response()->json('error',200);
    }
//    分类删除方法
    public function catedel(Request $request,$mode){
        if ($mode=='main'){
            $res=$request->input('products');
            $res=explode(',',$res);
            foreach ($res as $k=>$v){
                Main::where('class_id',$v)->first()->delete();
                $idss=clas::where('main_class',$v)->get();
                $id_arr=array();
                foreach ($idss as $ke=>$val){
                    $id_arr[]=$val->class_id;
                }
                foreach ($id_arr as $kk=>$va){
                    $proid=product::where('class_id',$va)->get();
                    foreach ($proid as $e=>$vse){
                        $rr=pre_img::where('detail_id',$vse)->get();
                        foreach ($rr as $wewe=>$ds){
                            unlink(env('FILE_PATH').$ds->address);
                        }
                        pre_img::where('detail_id',$vse)->delete();
                    }
                    product::where('class_id',$va)->delete();
                }
                clas::where('main_class',$v)->delete();

            }
            return response()->json('ok',200);
        }else{
            $re=$request->input('products');
            $res=explode(',',$re);
            foreach ($res as $k=>$v){
                clas::where('class_id',$v)->delete();
                $rr=product::where('class_id',$v)->get();
                foreach ($rr as $kg=>$vs){
                    $rs=pre_img::where('detail_id',$vs->id)->get();
                    foreach ($rs as $yu){
                        unlink(env('FILE_PATH').$yu->address);
                    }
                    pre_img::where('detail_id',$vs->id)->delete();
                }
                product::where('class_id',$v)->delete();
            }
            return response()->json('oks',200);
        }
    }

//    分类列表主/子分类切换，ajax方法
    public function shows($mode){
        if ($mode=='main'){
            $res=Main::all();
            return response()->json($res,200);
        }else{
            $res=clas::all();
            return response()->json($res,200);
        }
    }

//    分类编辑页显示路由
    public function catelist(){
        $main=Main::all();
        return view('admin.catelist',['main'=>$main]);
    }
//    分类添加接口
    public function cateadd(Request $request){
        $mins=$request->input('main');
        $proname=$request->input('name');
        $bz=$request->input('bz');
        if ($mins=='e'){
            $m=new Main;
            $m->pro_name=$proname;
            $m->preview=$bz;
            $m->save();
            return response()->json('ok',200);
        }else{
            $m=new clas;
            $m->class_name=$proname;
            $m->preview=$bz;
            $mi=Main::where('class_id',$mins)->first();
            $m->main_name=$mi->pro_name;
            $m->main_class=$mi->class_id;
            $m->save();
            return response()->json('ok',200);
        }
    }
//    分类编辑页面显示方法
    public function category(){
        $main=Main::all();
        return view('admin.category',['main'=>$main]);
    }
//    产品批量删除方法
    public function delpro(Request $request){
        $id_arr=$request->input('products');
        $id_arr=explode(',',$id_arr);
        foreach ($id_arr as $k=>$v){
            product::where('id',$v)->first()->delete();
            detail::where('detail_id',$v)->first()->delete();
            $path=pre_img::where('detail_id',$v)->first();
            unlink(env('FILE_PATH').$path->address);
            pre_img::where('detail_id',$v)->delete();
        }
        return response()->json('ok',200);
    }
//    产品添加入库方法
    public function proreg(){
        $clas=$_POST['clas'];
        $ids=$_POST['ids'];
        $content=$_POST['content'];
        $proname=$_POST['proname'];
        $price=$_POST['price'];
        $pro=new product;
        $pro->class_id=$clas;
        $pro->info=$proname;
        $pro->price=$price;
        $sdress=temp_img::where('id',$ids[0])->first();
        $pro->prview_img=$sdress->path;
        $pro->save();
        $id=product::where('prview_img',$sdress->path)->first();
        $id=$id->id;
        $sese=new detail;
        $sese->name=$proname;
        $sese->content=$content;
        $sese->detail_id=$id;
        $sese->save();
        foreach ($ids as $k=>$v){
           $img=new pre_img;
           $img->detail_id=$id;
           $ppt=temp_img::where('id',$v)->first();
           $img->address=$ppt->path;
           $ppt->delete();
           $img->save();
        }
        return response()->json('ok',200);
    }

//    缓存图片查看方法
    public function tmpimg($id){
        $res=temp_img::where('id',$id)->first();
        $res=$res->path;
        return response()->json($res,200);
    }

//    商品添加方法
    public function proadd(){
        $classs=clas::all();
        $main=Main::all();
        $id=product::select('id')->orderBy('id','desc')->limit(1)->get();
        return view('admin.proadd',['class'=>$classs,'main'=>$main,'id'=>$id[0]->id+1]);
    }

//    获取时间方法
    public function gettime(){
        $time=date('Y-m-d H:i:s',time());
        return response()->json($time,200);
    }

//    产品删除方法
    public function prodel($id){
        product::where('id',$id)->first()->delete();
        pre_img::where('detail_id',$id)->get()->delete();
        detail::where('id',$id)->first()->delete();
        return response()->json('ok',200);
    }

//    产品编辑方法
    public function prochange(){
        $id=$_POST['id'];
        $title=$_POST['title'];
        $content=$_POST['content'];
        $pro=product::where('id',$id)->first();
        $det=detail::where('detail_id',$id)->first();
        $det->name=$title;
        $pro->info=$title;
        $det->content=$content;
        $pro->save();
        $det->save();

        return response()->json('ok',200);
    }

//    产品页面显示方法
    public function proEdit($id){
        $res=product::where('id',$id)->first();
        $detail=detail::where('detail_id',$id)->first();
        $imgs=pre_img::where('detail_id',$id)->get();
        return view('admin.proEdit',['res'=>$res,'content'=>$detail,'img'=>$imgs]);
    }

//    后台登录方法
    public function login(Request $request){
        $res=$request->input('somefield');
        $username=$res['user'];
        $pwd=$res['password'];
        $safecode=$res['code'];
        if ($safecode!=session('codes')){
            return response()->json('code error',200);
        }
        $db=adm::where('nick_name',$username)->first();
        if ($db==null||$db==''){
            return response()->json('user not exits',200);
        }
        if ($db->password!=sha1('se'.$pwd)){
            return response()->json('pwd error',200);
        }
            session(['adminuser'=>$username]);
            return response()->json('ok',200);
        
    }

//    查看图片列表方法
    public function img_list(){
        $res=product::all();
        $classid=array();
        foreach ($res as $k=>$v){
            $classid[]=$v->class_id;
        }
        $classname=array();
        for ($i=0;$i<count($classid);$i++){
            $classname[]=clas::where('class_id',$classid[$i])->first();
        }
        $count=count($res);
        return view('admin.img_list',['name'=>$classname,'id'=>$res,'num'=>$count]);
    }

//    查看用户列表方法
    public function memberlist(){
        $res=User2::all();
        $count=count($res);
        return view('admin.memberlist',['res'=>$res,'num'=>$count]);
    }

//    同一商品下的图片查看
    public function img_show($id){
        $res=pre_img::where('detail_id',$id)->get();
        $count=count($res);
        return view('admin.img_show',['res'=>$res,'num'=>$count]);
    }

//    图片添加方法
    public function addimg(){
        $classs=clas::all();
        $main=Main::all();
        $pro=product::all();
        return view('admin.picture-add',['class'=>$classs,'main'=>$main,'all'=>$pro]);
    }

//    图片上传方法
    public function imgupload(Request $request){
        $names='jg';
        if (!empty($_FILES[$names]['tmp_name'])) {
            $filept=$this->upload($names,env('FILE_PATH').'/upload',20);
        }
        if ($filept!='error'){
            $id=$request->input('pro');
            $index=strpos($filept,'/upload');
            $path=substr($filept,$index);
//            return $path;
            if ($id==null||$id==''){
                $res=new temp_img;
                $res->path=$path;
                $res->save();
                $ids=temp_img::select('id')->where('path',$path)->first();
                $ids=$ids->id;
                $_SESSION['imgid']=$ids;
                return response()->json($ids,200);
            }
            $res=new pre_img;
            $res->address=$path;
            $res->detail_id=$id;
            $res->save();
            return "<script>history.go(-1);</script>";
        }
    }

    public function upload($upName,$upDir,$upSize){
        if (!file_exists($upDir)) {
            mkdir($upDir);
        }
        if (is_uploaded_file($_FILES[$upName]['tmp_name'])) {
            if ($_FILES[$upName]['size']<=$upSize*1024*1024) {
                $class=explode('.',$_FILES[$upName]['name']);
                $classs=['png','jpg','gif'];
                if (in_array($class[count($class)-1],$classs)) {
                    $time=md5(microtime());
                    if (!file_exists($upDir.'/'.$class[count($class)-1])) {
                        mkdir($upDir.'/'.$class[count($class)-1]);
                        move_uploaded_file($_FILES[$upName]['tmp_name'],$upDir.'/'.$class[count($class)-1].'/'.$time.'.'.$class[count($class)-1]);
                        $filepeth=$upDir.'/'.$class[count($class)-1].'/'.$time.'.'.$class[count($class)-1];
                        return $filepeth;
                    }else{
                        move_uploaded_file($_FILES[$upName]['tmp_name'],$upDir.'/'.$class[count($class)-1].'/'.$time.'.'.$class[count($class)-1]);
                        $filepeth=$upDir.'/'.$class[count($class)-1].'/'.$time.'.'.$class[count($class)-1];
                        return $filepeth;
                    }
                }
            }
        }
        return 'error';
    }

//    图片删除方法
    public function imgdel(Request $request){
        $resid=$request->input('products');
        $resid=explode(',',$resid);
        $del_arr=array();
        foreach ($resid as $k=>$v){
            $del=pre_img::where('id',$v)->first();
            $del_arr[]=$del->address;
            pre_img::where('id',$v)->first()->delete();
        }
        foreach ($del_arr as $val){
            unlink(env('FILE_PATH').$val);
        }
        return response()->json('ok',200);
    }
}
