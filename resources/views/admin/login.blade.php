@extends('admin.master')
@section('content')
    <input type="hidden" id="TenantId" name="TenantId" value="" />

    <div class="loginWraper">
        <div id="loginform" class="loginBox">
            <div class="form form-horizontal">
                <div class="row cl">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                    <div class="formControls col-xs-8">

                        <input id="user" name="username" type="text" placeholder="账户" class="input-text size-L"><br/><span style="color: red" id="utp"></span>
                        <script>
                            let user=document.getElementById('user');
                            if ('oninput' in user){
                                user.addEventListener('input',getuser,false);
                            }else{
                                user.onpropertychange=getuser;
                            }
                            let users='';
                            function getuser() {
                                document.getElementById('ptp').innerHTML='';
                                users=user.value;
                                if (users.length<9){
                                    document.getElementById('utp').innerHTML='用户名过短';
                                }
                                if (users.length==0||users.length>=9){
                                    document.getElementById('utp').innerHTML='';
                                }
                                if (users.length>16){
                                    document.getElementById('utp').innerHTML='用户名过长';
                                }
                            }
                        </script>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                    <div class="formControls col-xs-8">
                        <input id="pwd" name="password" type="password" placeholder="密码" class="input-text size-L"><br/><span style="color: red" id="ptp"></span>
                        <script>
                            let pwd=document.getElementById('pwd');
                            if ('oninput' in pwd){
                                pwd.addEventListener('input',getpwd,false);
                            }else{
                                pwd.onpropertychange=getpwd;
                            }
                            let pwds;
                            function getpwd() {
                                if (users==''){
                                    document.getElementById('ptp').innerHTML='请先输入用户名!';
                                    pwd.value='';
                                    return;
                                }
                                pwds=pwd.value;
                                if (pwds.length<9){
                                    document.getElementById('ptp').innerHTML='密码过短';
                                }
                                if (pwds.length==0||pwds.length>9){
                                    document.getElementById('ptp').innerHTML='';
                                }
                            }
                        </script>
                    </div>
                </div>
                <div class="row cl">
                    <div class="formControls col-xs-8 col-xs-offset-3">
                        <input id="safecode" name="safecode" class="input-text size-L" type="text" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
                        <img src="/qrcode" style="width: 140px" id="safescode"> <a id="kanbuq" onclick="changecode()">看不清，换一张</a> </div>
                    <br/><span style="color: red" id="ctp"></span>
                    <script>
                        let code=document.getElementById('safecode');
                        if ('oninput' in code){
                            code.addEventListener('input',getcode,false);
                        }else{
                            code.onpropertychange=getcode;
                        }
                        let codes;
                        function getcode() {
                            codes=code.value;
                        }
                    </script>
                </div>
                <div class="row cl">
                    <p id="tips" style="color: red;margin-left:180px"></p>
                    <div class="formControls col-xs-8 col-xs-offset-3">
                        <input onclick="login()" name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                        <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">Copyright 微信书城 by TheShy v3.1</div>
    <script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script>
    <script>
        function login(){
            let dates={
                    user:users,
                    password:pwds,
                    code:codes,
                };
                $.ajax({
                url:'/admin/login/log',
                type:"POST",
                data:{
                    somefield: dates, _token: '{{csrf_token()}}'
                },
                success:function (data) {
                   if (data=='ok') {

                        location.href='/admin/index';

                    }
                    if (data=='code error') {

                        document.getElementById('tips').innerHTML='验证码错误';
                        setTimeout(function () {
                            document.getElementById('tips').innerHTML='';
                        },1500);

                    }
                    if (data=='pwd error') {

                        document.getElementById('tips').innerHTML='密码错误';
                        setTimeout(function () {
                            document.getElementById('tips').innerHTML='';
                        },1500);

                    }
                    if (data=='user not exits') {

                        document.getElementById('tips').innerHTML='用户名错误或不存在';
                        setTimeout(function () {
                            document.getElementById('tips').innerHTML='';
                        },1500);

                    }
                },
                error:function (data,status,error) {

                }
            })
        }
        function changecode() {
            document.getElementById('safescode').src='/qrcode?'+Math.random();
        }
        
    </script>
@endsection