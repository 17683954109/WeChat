<?php

namespace App\Http\Controllers;

use App\Entity\User2;
use App\Entity\telcode;
use App\Entity\emcode;
use Illuminate\Http\Request;
use Mail;
use App\MailService;
// include "./sms/SendTemplateSMS.php";
// include "c:/myphp_www/phptutorial/www/wechat/laravel/public/sms/ServerAPI.php";

class userService extends Controller
{
    //用户登录方法
    public function login(){
        $mode=$_POST['somefield']['mode'];
    if ($mode=='tel'){
        $tels=$_POST['somefield']['tel'];
        $password=sha1('se'.$_POST['somefield']['password']);
        $codes=session('codes');
        $usercode=$_POST['somefield']['code'];
        if ($codes!=$usercode){
            return response()->json(1,200);
        }
        $tel=User2::where('phone',$tels)->first();
        if ($tel==null){
            return response()->json(2,200);
        }
        if ($tel->password!=$password){
            return response()->json(3,200);
        }
        session(['user'=>"$tels"]);
        return response()->json(4,200);
    }else{
        $emails=$_POST['somefield']['email'];
        $password=sha1('se'.$_POST['somefield']['password']);
        $codes=session('codes');
        $usercode=$_POST['somefield']['code'];
        if ($codes!=$usercode){
            return response()->json(1,200);
        }
        $email=User2::where('email',$emails)->first();
        if ($email==null){
            return response()->json(2,200);
        }
        if ($email->password!=$password){
            return response()->json(3,200);
        }
        session(['user'=>"$emails"]);
        return response()->json(4,200);
    }
    }

//    用户注册方法
    public function reg($mode){
        if ($mode=='tel'){
        $tel=$_POST['somefield']['tel'];
        $user=User2::where('phone',$tel)->first();
        if ($user!=null){
            return response()->json(1,200);
        }
        $password=$_POST['somefield']['telpasswd'];
        $smscode=$_POST['somefield']['smscode'];
        $code=new telcode();
        $smscd=$code->where('tel',$tel)->first();
        if ($smscd->code==$smscode&&strtotime($smscd->deadline)>time()){
            $member=new User2();
            $member->nick_name=time();
            $member->password=sha1('se'.$password);
            $member->phone=$tel;
            $member->save();
            session(['user'=>"$tel"]);
            return response()->json(4,200);
        }
        }else{
            $email=$_POST['somefield']['email'];
            $empassword=$_POST['somefield']['empassword'];
            $user=User2::where('email',$email)->first();
            if ($user!=null){
                return response()->json(1,200);
            }
            $code=rand(100001,999999);
            $emcode=emcode::where('email',$_POST['somefield']['email'])->first();
            if ($emcode==null){
                $emcode=new emcode();
            }
            $emailAd=$_POST['somefield']['email'];
            $emcode->email=$emailAd;
            $emcode->regcode=$code;
            $emcode->password=sha1('se'.$empassword);
            $emcode->save();
            $email=new MailService;
            $email->to=$emailAd;
            $email->cc='17683954109@163.com';
            $email->subject='TheShy';
            $email->content="<div>你的注册激活链接：<a href='http://www.we.com/login/$emailAd/$code'>$code</a> 请于五分钟内完成注册！</div>";

            Mail::send('emails.code',['email'=>$email],function($m) use ($email){
                $m->to($email->to,'你好:')
                    ->cc($email->cc)
                    ->subject($email->subject);
            });
                return response()->json(4,200);
            }


        return response()->json(3,200);

    }
//    手机验证码获取方法
    public function getSmsCode(){

        $code=rand(100001,999999);
        $smsCode=telcode::where('tel',$_POST['somefield']['tel'])->first();
        if ($smsCode==null){
            $smsCode=new telcode();
        }
        $smsCode->tel=$_POST['somefield']['tel'];
        $tel=$_POST['somefield']['tel'];
        $smsCode->code=$code;
        $smsCode->deadline=date('YmdHis',time()+5*60);
        $smsCode->save();
        $code=urlencode('#code#='.$code);
        $res=file_get_contents("http://v.juhe.cn/sms/send?mobile=$tel&tpl_id=82471&tpl_value=$code&key=1e26d14233a9fa5af23487b689225f0d");

        return response()->json($res,200);
    }

//  curl模拟发送post请求
    public function curl_post_https($url,$data){ // 模拟提交数据函数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
//        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
//        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
//        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
//        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
//        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据，json格式
    }
//    邮箱注册链接激活方法
    public function getlogup($email,$code){
        $user=User2::where('email',$email)->first();
        if ($user!=null){
            return response()->json('user exits',200);
        }
        $codes=new emcode();
        $emcode=$codes->where('email',$email)->first();
        if ($emcode->regcode==$code&&$emcode->email==$email){
            $member=new User2();
            $member->nick_name=time();
            $member->password=$emcode->password;
            $member->email=$email;
            $member->save();
            session(['user'=>"$email"]);
            return redirect('/goods');
        }
    }
}

