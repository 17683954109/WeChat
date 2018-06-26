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

class admin extends Controller
{
//    商品添加方法
    public function proadd(){
        $classs=clas::all();
        $main=Main::all();
        return view('admin.proadd',['class'=>$classs,'main'=>$main]);
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
        $det=detail::where('id',$id)->first();
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
        $detail=detail::where('id',$id)->first();
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
        if ($res['online']=='yes') {
           return response()->json('ok',200)->withCookie('adminuser',"$username",3600);
        }else{
            session(['adminuser'=>"$username"]);
            return response()->json('ok',200);
        }
        
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
//        $name=$_FILES['jg']['name'];
//        $type=explode('.',$name);
//        $filetype=$type[count($type)-1];
//        $filename=md5(time().rand(100,999)).'.'.$filetype;
//        return $filename;
        $names='jg';
        if (!empty($_FILES[$names]['tmp_name'])) {
            $filept=$this->upload($names,'C:/myphp_www/PHPTutorial/WWW/wechat/laravel/public/upload',20);
        }
        if ($filept!='error'){
            $id=$request->input('pro');
            $index=strpos($filept,'/upload');
            $path=substr($filept,$index);
//            return $path;
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
//                        echo '文件上传成功！'.'存放目录：'.$upDir.'/'.$class[count($class)-1];
                        $filepeth=$upDir.'/'.$class[count($class)-1].'/'.$time.'.'.$class[count($class)-1];
                        return $filepeth;
                    }else{
                        move_uploaded_file($_FILES[$upName]['tmp_name'],$upDir.'/'.$class[count($class)-1].'/'.$time.'.'.$class[count($class)-1]);
//                        echo '文件上传成功！'.'存放目录：'.$upDir.'/'.$class[count($class)-1];
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
//            return response()->json($val,200);
            unlink('C:/myphp_www/PHPTutorial/WWW/wechat/laravel/public'.$val);
        }
        return response()->json('ok',200);
    }
}
