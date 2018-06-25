<?php

namespace App\Http\Controllers;
use App\Entity\admin as adm;
use Illuminate\Http\Request;
use App\Entity\pre_img;
use App\Entity\product;
use App\Entity\clas;
use App\Entity\User2;

class admin extends Controller
{
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
        return view('admin.picture-add');
    }
}
