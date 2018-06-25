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
    public function memberlist(){
        $res=User2::all();
        $count=count($res);
        return view('admin.memberlist',['res'=>$res,'num'=>$count]);
    }
    public function img_show(){
        return view('admin.img_show');
}
}
