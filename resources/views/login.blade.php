@extends('master')
@section('title','登录页面')
@section('icon')
    <link rel="icon" href="/images/reg.ico">
@endsection
@section('content')
    {{--<p style="font-size: 16px;text-align: center;height: 50px;line-height: 50px">用户注册</p>--}}
    <!-- navibar导航 -->
    {{--<div class="weui-tab">--}}
        {{--<div class="weui-navbar">--}}
            {{--<div class="weui-navbar__item weui-bar__item_on">--}}
                {{--登录/注册--}}
            {{--</div>--}}
            {{--<div class="weui-navbar__item">--}}
                {{--苹果产品--}}
            {{--</div>--}}
            {{--<div class="weui-navbar__item">--}}
                {{--购物车--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="weui-tab__panel">
            <div><!-- weui表单 -->
                <div class="weui-cells__title">登录方式</div>
                <div class="weui-cells weui-cells_radio">
                    <label class="weui-cell weui-check__label" for="x11">
                        <div class="weui-cell__bd">
                            <p>手机号登录</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" class="weui-check" name="radio1" id="x11" checked="checked" onclick="so('x11')">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x12">

                        <div class="weui-cell__bd">
                            <p>邮箱账号登录</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="radio1" class="weui-check" id="x12" onclick="so('x12')">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                </div>

                {{--手机号登录开始--}}
                <div class="phoneReg" style="display: block" id="phone">
                    <div class="weui-cells__title">手机号登录</div>
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell weui-cell_vcode">
                            <div class="weui-cell__hd">
                                <label class="weui-label">手机号</label>
                            </div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="number" placeholder="请输入手机号" id="tel"><span style="color: red;font-size: 5px" id="teltips"></span>

                                {{--获取用户输入的手机号--}}
                                <script>
                                    let tel=document.getElementById('tel');
                                    if ('oninput' in tel) {
                                        tel.addEventListener('input',gettel,false)
                                    }else{
                                        tel.onpropertychange=gettel;
                                    }
                                    var telphone;
                                    function gettel() {
                                        // document.getElementById('getcode').innerHTML=tel.value;
                                        telphone=tel.value;
                                        if (telphone.length==11){
                                            document.getElementById('teltips').innerHTML='';
                                        }
                                        if (telphone.length>11){
                                            document.getElementById('teltips').innerHTML='手机号过长！'
                                        }
                                        if (telphone.length<11){
                                            document.getElementById('teltips').innerHTML='手机号过短！'
                                        }
                                        if (telphone.length==0){
                                            document.getElementById('teltips').innerHTML='';
                                        }
                                    }

                                </script>


                            </div>
                        </div>
                        <div style="margin-top: 20px"></div>
                        <div style="margin-top: 20px"></div>
                        <div style="margin-top: 20px"></div>
                        <div class="weui-cell weui-cell_vcode">
                            <div class="weui-cell__hd">
                                <label class="weui-label">密码</label>
                            </div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="password" placeholder="请输入密码" name="password" id="telpwd"><span style="color: red;font-size: 5px" id="telpwdtips"></span>

                                {{--获取用户输入的密码--}}
                                <script>
                                    let telpwd=document.getElementById('telpwd');
                                    if ('oninput' in telpwd){
                                        telpwd.addEventListener('input',gettelpwd,false);
                                    }else{
                                        telpwd.onpropertychange=gettelpwd;
                                    }
                                    var telpasswd;
                                    function gettelpwd() {
                                        telpasswd=telpwd.value;
                                        if (telpasswd.length>11){
                                            document.getElementById('telpwdtips').innerHTML='';
                                        }
                                        if(telpasswd.length<11){
                                            document.getElementById('telpwdtips').innerHTML='密码过短!';
                                        }
                                        if (telpasswd.length==0){
                                            document.getElementById('telpwdtips').innerHTML='';
                                        }
                                    }
                                </script>

                            </div>
                        </div>
                        <div style="margin-top: 20px"></div>
                        <div class="weui-cell weui-cell_vcode">
                            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" placeholder="验证码" id="conf"/><span style="color: red;font-size: 5px" id="telcode"></span>

                            {{--获取用户输入的验证码--}}

                                <script>
                                let telqrcodes=document.getElementById('conf');
                                if ('oninput' in telqrcodes){
                                telqrcodes.addEventListener('input',getqrcode,false);
                                }else{
                                telqrcodes.onpropertychange=getqrcode;
                                }
                                var telqrcode;
                                function getqrcode() {
                                telqrcode=telqrcodes.value;
                                }
                                </script>

                            </div>
                            <div class="weui-cell__ft">
                                <img src="/qrcode?a=" onclick="this.src=this.src+Math.random()" style="margin-right: 15px" />
                            </div>
                        </div>
                    </div>
                </div>

                {{--手机号登录结束--}}

                {{--邮箱登录开始--}}
                <div class="emailReg" style="display: none" id="email">
                    <div class="weui-cells__title">邮箱登录</div>
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell weui-cell_vcode">
                            <div class="weui-cell__hd">
                                <label class="weui-label">邮箱地址</label>
                            </div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" placeholder="请输入邮箱" id="emails"><span style="color: red;font-size: 5px" id="emailtips"></span>

                                {{--获取用户输入的邮箱验证码--}}
                                <script>
                                    let em=document.getElementById('emails');
                                    if ('oninput' in em){
                                        em.addEventListener('input',getemail,false);
                                    }else{
                                        em.onpropertychange=getemail;
                                    }
                                    var emails;
                                    function getemail() {
                                        emails=em.value;
                                        ems=toString(emails);
                                    }
                                </script>

                            </div>
                        </div>
                        <div style="margin-top: 20px"></div>
                        <div class="weui-cell weui-cell_vcode">
                            <div class="weui-cell__hd">
                                <label class="weui-label">密码</label>
                            </div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="password" placeholder="请输入密码" name="sis" id="empwd"><span style="color: red;font-size: 5px;" id="empwdtips"></span>

                                {{--获取用户输入的邮箱密码--}}
                                <script>
                                    let empwd=document.getElementById('empwd');
                                    if ('oninput' in empwd) {
                                        empwd.addEventListener('input',getempwd,false);
                                    }else{
                                        empwd.onpropertychange=getempwd;
                                    }
                                    var empasswd;
                                    function getempwd() {
                                        empasswd=empwd.value;
                                        let emtip=document.getElementById('empwdtips');
                                        if (empasswd.length<11){
                                            emtip.innerHTML='密码过短!';
                                        }else{
                                            emtip.innerHTML='';
                                        }
                                        if (empasswd.length>16){
                                            emtip.innerHTML='密码过长!';
                                        }
                                        if (empasswd.length==0){
                                            emtip.innerHTML='';
                                        }
                                    }
                                </script>

                            </div>
                        </div>
                        <div style="margin-top: 20px"></div>
                        <div class="weui-cell weui-cell_vcode">
                            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" placeholder="验证码" id="emcode"/><span style="color: red;font-size: 5px;" id="emyzm"></span>
                                {{--获取用户输入的邮箱验证码--}}
                                <script>
                                    let emcd=document.getElementById('emcode');
                                    if ('oninput' in emcd){
                                        emcd.addEventListener('input',getemcode,false);
                                    }else{
                                        emcd.onpropertychange=getemcode;
                                    }
                                    var emqrcode;
                                    function getemcode() {
                                        emqrcode=emcd.value;

                                        if (emqrcode.length<6){
                                            document.getElementById('emyzm').innerHTML='验证码过短!';
                                        }

                                        if (emqrcode.length>3){
                                            document.getElementById('emyzm').innerHTML='';
                                        }
                                        if (emqrcode.length>6){
                                            document.getElementById('emyzm').innerHTML='验证码过长!';
                                        }
                                        if (emqrcode.length==0){
                                            document.getElementById('emyzm').innerHTML='';
                                        }
                                    }
                                </script>

                            </div>
                            <div class="weui-cell__ft">
                                <img src="/qrcode?a=" onclick="this.src=this.src+Math.random()" style="margin-right: 15px" />
                            </div>
                        </div>
                    </div>

                </div>

                {{--邮箱登录结束--}}

                <div class="weui-btn-area">
                    <a class="weui-btn weui-btn_primary" id="showTooltips" onclick="sendform()">登录</a>
                </div>
                <div style="width: 100%;margin: 0 auto;text-align: center">
                    <a href="/register" style="color: green;margin-right: 100px">没有账号？去注册</a>
                    <a href="/register" style="color: green">忘记密码</a>
                </div>
            </div>
            <div style="display:none">Page 2</div>
            <div style="display:none">Page 3</div>
        </div>
    </div>
    {{--<div id="loadingToast" style="display:none;">--}}
        {{--<div class="weui-mask_transparent"></div>--}}
        {{--<div class="weui-toast">--}}
            {{--<i class="weui-loading weui-icon_toast"></i>--}}
            {{--<p class="weui-toast__content" id="toast">请等待60秒</p>--}}
        {{--</div>--}}
    {{--</div>--}}

@endsection
@section('my-js')
    <script type="text/javascript">
        let sendmode='tel';
        function so(id) {
            if(id=='x11'){
                document.getElementById('phone').style.display='block';
                document.getElementById('email').style.display='none';
                sendmode='tel';
            }else{
                document.getElementById('phone').style.display='none';
                document.getElementById('email').style.display='block';
                sendmode='email';
            }
        }
        //    手机号保存在变量 telphone 中
        //    手机注册的密码保存在变量 telpasswd 中
        //    手机注册的验证码保存在变量 telqrcode 中
        //    邮箱注册的邮箱地址保存在变量 emails 中
        //    邮箱注册的密码保存在变量 empasswd 中
        //    邮箱注册的验证码保存在变量 emqrcode 中
        function sendform() {
            let tip=document.getElementById('toasts');
            let tips=document.getElementById('resoult');
            if (sendmode=='tel'){
                if (telphone.length!=11||!telqrcode.length>3||!telpasswd.length>=11){
                    tips.innerHTML='填写有误!';
                    tip.style.display='block';
                    setTimeout(function () {
                        tip.style.display='none';
                        tips.innerHTML='已发送!';
                    },1000);
                    return;
                }
                let dates={
                    tel:telphone,
                    password:telpasswd,
                    code:telqrcode,
                    mode:sendmode

                };
                $.ajax({
                    url:'/login/login',
                    type:"POST",
                    data:{
                        somefield: dates, _token: '{{csrf_token()}}'
                    },
                    success:function (data) {
                        if (data==4){
                            tip.style.display='block';
                            tips.innerHTML='登录成功!';
                            setTimeout(function () {
                                tip.style.display='none';
                                tips.innerHTML='已发送!';
                                @if($return_url!='')
                            window.location.href="{{$return_url}}";
                            @else
                                window.location.href="/goods";
                                @endif
                            },1000);
                        }
                        if (data==3){
                            tip.style.display='block';
                            tips.innerHTML='密码错误!';
                            setTimeout(function () {
                                tip.style.display='none';
                                tips.innerHTML='已发送!';
                            },1000);
                        }
                        if (data==1){
                            tip.style.display='block';
                            tips.innerHTML='验证码错误!';
                            setTimeout(function () {
                                tip.style.display='none';
                                tips.innerHTML='已发送!';
                            },1000);
                        }
                        if (data==2){
                            tip.style.display='block';
                            tips.innerHTML='手机号错误!';
                            setTimeout(function () {
                                tip.style.display='none';
                                tips.innerHTML='已发送!';
                            },1000);
                        }
                        console.log(data);
                    },
                    error:function (data,status,error) {
                        tip.style.display='block';
                        tips.innerHTML='登录失败!';
                        setTimeout(function () {
                            tip.style.display='none';
                            tips.innerHTML='已发送!';
                        },1000);
                        console.log(data);
                    }
                })
            }else{
                if (!emails.search('@')||!emails.search('com')){
                    tips.innerHTML='填写有误!';
                    tip.style.display='block';
                    setTimeout(function () {
                        tip.style.display='none';
                        tips.innerHTML='已发送!';
                    },1000);
                    return;
                }
                let dates={
                    email:emails,
                    password:empasswd,
                    code:emqrcode,
                    mode:sendmode
                };
                $.ajax({
                    url:'/login/login',
                    type:'POST',
                    data:{
                        somefield:dates,
                        _token:"{{csrf_token()}}"
                    },
                    success:function (data) {
                        if (data==2){
                            tip.style.display='block';
                            tips.innerHTML='邮箱地址错误!';
                            setTimeout(function () {
                                tip.style.display='none';
                                tips.innerHTML='已发送!';
                            },1000);
                        }
                        if (data==3){
                            tip.style.display='block';
                            tips.innerHTML='密码错误!';
                            setTimeout(function () {
                                tip.style.display='none';
                                tips.innerHTML='已发送!';
                            },1000);
                        }
                        if (data==1){
                            tip.style.display='block';
                            tips.innerHTML='验证码错误!';
                            setTimeout(function () {
                                tip.style.display='none';
                                tips.innerHTML='已发送!';
                            },1000);
                        }
                        if (data==4){
                            tip.style.display='block';
                            tips.innerHTML='登录成功!';
                            setTimeout(function () {
                                tip.style.display='none';
                                tips.innerHTML='已发送!';
                                window.location.href='/goods';
                            },1000);
                        }
                        console.log(data);
                    },
                    error:function (data,status,error) {
                        tip.style.display='block';
                        tips.innerHTML='登录失败!';
                        setTimeout(function () {
                            tip.style.display='none';
                            tips.innerHTML='已发送!';
                        },1000);
                        console.log(data);
                    }
                })
            }
        }
    </script>
@endsection
