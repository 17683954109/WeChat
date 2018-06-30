@extends('master')
@section('title','注册页面')
@section('icon')
<link rel="icon" href="/images/reg.ico">
@endsection
@section('content')
    <div class="weui-tab__panel">
        <div id="pa1"><!-- weui表单 -->
<div class="weui-cells__title">注册方式</div>
<div class="weui-cells weui-cells_radio">
    <label class="weui-cell weui-check__label" for="x11">
        <div class="weui-cell__bd">
            <p>手机号注册</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" class="weui-check" name="radio1" id="x11" checked="checked" onclick="so('x11')">
            <span class="weui-icon-checked"></span>
        </div>
    </label>
    <label class="weui-cell weui-check__label" for="x12">

        <div class="weui-cell__bd">
            <p>邮箱注册</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" name="radio1" class="weui-check" id="x12" onclick="so('x12')">
            <span class="weui-icon-checked"></span>
        </div>
    </label>
</div>

{{--手机号注册开始--}}
<div class="phoneReg" style="display: block" id="phone">
<div class="weui-cells__title">手机号注册</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd">
            <label class="weui-label">手机号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="number" placeholder="请输入手机号" id="tel"><span id="teltips" style="color:red;font-size: 5px"></span>


        </div>
        <div class="weui-cell__ft">
            <a class="weui-vcode-btn" id="getcode" onclick="getsmscode()" style="color: green">获取验证码</a>
        </div>
    </div>
    <div style="margin-top: 20px"></div>
	<div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd">
            <label class="weui-label">短信验证码</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="number" placeholder="短信验证码" id="smscode"><span id="smstips" style="color:red;font-size: 5px"></span>

        </div>
    </div>
    <div style="margin-top: 20px"></div>
    <div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd">
            <label class="weui-label">密码</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="password" placeholder="请设置密码" name="sis" id="passwd">
            <span id="tipss" style="color: red;font-size: 5px"></span>

        </div>
    </div>
    <div style="margin-top: 20px"></div>
    <div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd">
            <label class="weui-label">确认密码</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="password" placeholder="请确认密码" name="password" id="confpwd"><span id="tips" style="color: red;font-size: 5px"></span>

        </div>
    </div>
    <div style="margin-top: 20px"></div>

</div>
</div>

{{--手机号注册结束--}}

{{--邮箱注册开始--}}
<div class="emailReg" style="display: none" id="email">
                <div class="weui-cells__title">邮箱注册</div>
                <div class="weui-cells weui-cells_form">
                    <div class="weui-cell weui-cell_vcode">
                        <div class="weui-cell__hd">
                            <label class="weui-label">邮箱地址</label>
                        </div>
                        <div class="weui-cell__bd">
                            <input class="weui-input" type="text" placeholder="请输入邮箱" id="uemail">



                        </div>
                    </div>
                    <div style="margin-top: 20px"></div>

                    <div style="margin-top: 20px"></div>
                    <div class="weui-cell weui-cell_vcode">
                        <div class="weui-cell__hd">
                            <label class="weui-label">密码</label>
                        </div>
                        <div class="weui-cell__bd">
                            <input class="weui-input" type="password" placeholder="请设置密码" name="sis" id="empwd"><span style="color: red;font-size: 5px" id="emtip"></span>

                        </div>
                    </div>
                    <div style="margin-top: 20px"></div>
                    <div class="weui-cell weui-cell_vcode">
                        <div class="weui-cell__hd">
                            <label class="weui-label">确认密码</label>
                        </div>
                        <div class="weui-cell__bd">
                            <input class="weui-input" type="password" placeholder="请确认密码" name="password" id="confempwd"><span style="color: red;font-size: 5px" id="emtips"></span>

                        </div>
                    </div>
                    <div style="margin-top: 20px"></div>

                </div>
</div>

{{--邮箱注册结束--}}

<label for="weuiAgree" class="weui-agree">
    <input id="agreexy" type="checkbox" class="weui-agree__checkbox" checked="checked" onclick="return false">
    <span class="weui-agree__text">
        阅读并同意<a href="javascript:void(0);">《相关条款》</a>
    </span>
</label>

<div class="weui-btn-area">
    {{csrf_field()}}
    <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips" onclick="sendform()">注册</a>
</div>
            <div style="width: 100%;margin: 0 auto;text-align: center"><a href="/login" style="color: green">已有账号？去登录</a></div>
        </div>
        <div style="display:none" id='pa2'>苹果产品</div>
        <div style="display:none" id='pa3'>购物车</div>
    </div>
<div id="loadingToast" style="display:none;">
    <div class="weui-mask_transparent"></div>
    <div class="weui-toast">
        <i class="weui-loading weui-icon_toast"></i>
        <p class="weui-toast__content" id="toast">请等待60秒</p>
    </div>
</div>

@endsection
@section('my-js')
<script type="text/javascript">
    {{--获取用户输入的手机号--}}

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

    {{--获取用户输入的短信验证码--}}

    let smscode=document.getElementById('smscode');
    if ('oninput' in smscode){
        smscode.addEventListener('input',getsms,false);
    }else{
        smscode.onpropertychange=getsms;
    }
    var smscodes;
    function getsms() {
        smscodes=smscode.value;
        if (smscodes.length==6){
            document.getElementById('smstips').innerHTML=''
        }
        if (smscodes.length>6){
            document.getElementById('smstips').innerHTML='验证码过长!'
        }
        if (smscodes.length<6){
            document.getElementById('smstips').innerHTML='验证码过短!'
        }
        if (smscodes.length==0){
            document.getElementById('smstips').innerHTML=''
        }
    }

    {{--获取用户输入的密码--}}

    let passwd=document.getElementById('passwd');
    if ('oninput' in passwd){
        passwd.addEventListener('input',getpasswd,false);
    }else{
        passwd.onpropertychange=getpasswd;
    }
    var telpaswd;
    function getpasswd() {
        telpaswd=passwd.value;
        if (telpaswd.length>11){
            document.getElementById('tipss').innerHTML='';
        }
        if(telpaswd.length<11){
            document.getElementById('tipss').innerHTML='密码过短!';
        }
        if (telpaswd.length==0){
            document.getElementById('tipss').innerHTML='';
        }
    }

    {{--对用户两次输入的密码进行对比--}}

    let confpwd=document.getElementById('confpwd');
    if ('oninput' in confpwd){
        confpwd.addEventListener('input',getconfwd,false);
    }else{
        confpwd.onpropertychange=getconfwd;
    }
    var confpasswd;
    var telpasswd;
    function getconfwd() {
        confpasswd=confpwd.value;
        let telwd=telpaswd.toString();
        let telconfwd=confpasswd.toString();
        if (!telwd.search(telconfwd)){
            telpasswd=confpasswd;
            document.getElementById('tips').innerHTML='';
        }else{
            document.getElementById('tips').innerHTML='密码不相同';
        }
        if (confpasswd.length==0){
            document.getElementById('tips').innerHTML='';
        }
    }

    {{--获取用户输入的邮箱地址--}}

    let emails=document.getElementById('uemail');
    if ('oninput' in emails){
        emails.addEventListener('input',getemail,false);
    }else{
        emails.onpropertychange=getemail;
    }
    var useremail;
    function getemail() {
        useremail=emails.value;
    }


    {{--获取邮箱注册方式的用户输入的密码--}}

    let empwd=document.getElementById('empwd');
    if ('oninput' in empwd){
        empwd.addEventListener('input',getemwd,false);
    }else{
        empwd.onpropertychange=getemwd;
    }
    var empasswd;
    function getemwd() {
        empasswd=empwd.value;
        if(empasswd.length>9){
            document.getElementById('emtip').innerHTML='';
        }

        if (empasswd.length<9) {
            document.getElementById('emtip').innerHTML='密码过短';
        }
        if (empasswd.length>16) {
            document.getElementById('emtip').innerHTML='密码过长';
        }
        if(empasswd.length==0){
            document.getElementById('emtip').innerHTML='';
        }
    }

    {{--对邮箱注册方式的两次密码输入进行对比--}}

    let confempwd=document.getElementById('confempwd');
    if ('oninput' in confempwd){
        confempwd.addEventListener('input',getempwd,false);
    }else{
        confempwd.onpropertychange=getempwd;
    }
    var confemwd;
    var empassword;
    function getempwd() {
        confemwd=confempwd.value;
        let empws=empasswd.toString();
        let conff=confemwd.toString();
        if (!empws.search(conff)){
            empassword=confemwd;
            document.getElementById('emtips').innerHTML='';
        }else{
            document.getElementById('emtips').innerHTML='密码不相同';
        }
        if (confemwd.length==0){
            document.getElementById('emtips').innerHTML='';
        }
    }


    //获取验证码函数
    //验证码函数，控制为60秒才能发送一次请求
    //邮箱验证码获取
    let i=60;

    //短信验证码获取
    let smscodeinfo='';//用户获取验证码后改变该值
    let userxieyi='';//用户协议，默认为空，不勾选则不能注册
    function changexieyi() {
        if (userxieyi=''){
            userxieyi='false';
        }else{
            userxieyi='';
        }

    }
    function getsmscode() {
        if (telphone.length!=11){
            alert('表单填写有误！');
            return;
        }
        if(i!=60){
            document.getElementById('loadingToast').style.display='block';
            document.getElementById('toast').innerHTML='请等待'+i+'秒';
            setTimeout(function () {
                document.getElementById('loadingToast').style.display='none';
            },1000);
            return;
        }
        let dates={
            tel:telphone
        }
        $.ajax({
            type: "POST",
            url: '/login/getSmsCode',
            data: { somefield: dates, _token: '{{csrf_token()}}' },
            success: function (data) {
                document.getElementById('toasts').style.display='block';
                setTimeout(function () {
                    document.getElementById('toasts').style.display='none';
                },1000);
                smscodeinfo='yes';
                getcode();
            },
            error: function (data, textStatus, errorThrown) {
                document.getElementById('loadingToast').innerHTML='获取失败！';
                document.getElementById('loadingToast').style.display='block';
                setTimeout(function () {
                    document.getElementById('loadingToast').style.display='none';
                },1000);
            },
        });
    }


    //将等待再次发送的时间以倒计时的方式显示给用户
    function clocks()
    {
        i--;
        document.getElementById("getemailcode").innerHTML='重新发送'+i+'秒';
    }
    //切换注册方式函数
    var sendmode='tel';
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

    //手机号存储在变量 telphone 中
    //短信验证存储在变量 smscodes 中
    //手机注册的的密码存储在变量telpasswd 中
    //手机注册的图形验证码存储在变量 telqrcode 中
    // 邮箱地址存储在变量 useremail 中
    // 邮箱注册方式的邮箱验证码存储在变量 emailcodes 中
    // 邮箱注册方式的密码保存在变量 empassword 中
    // 邮箱方式注册的图形验证码保存在变量 emqrcode 中

    //ajax 提交注册表单
    function sendform() {
        if (sendmode=='tel'){  //手机注册提交表单
            //   验证表单是否合法
            if (telphone.length!=11||smscodes.length!=6||telpasswd.length<=9){
                alert('表单填写有误！');
                return;
            }
            if (smscodeinfo!='yes'){
                alert('请先获取验证码！');
                return;
            }
            let dates={
                tel:telphone,
                smscode:smscodes,
                telpasswd:telpasswd
            }
            $.ajax({
                type: "POST",
                url: '/login/adduser/tel',
                data: { somefield: dates, _token: '{{csrf_token()}}' },
                success: function (data) {
                    document.getElementById('resoult').innerHTML='注册成功！';
                    if (data==1) {
                        document.getElementById('resoult').innerHTML='用户已经注册过了！';
                    }
                    if (data==3) {
                        document.getElementById('resoult').innerHTML='验证码错误！';
                    }
                    document.getElementById('toasts').style.display='block';
                    setTimeout(function () {
                        document.getElementById('toasts').style.display='none';
                        location.href='/login';
                    },1000);
                },
                error: function (data, textStatus, errorThrown) {
                    document.getElementById('loadingToast').innerHTML='注册失败！';
                    document.getElementById('loadingToast').style.display='block';
                    setTimeout(function () {
                        document.getElementById('loadingToast').style.display='none';
                    },1000);

                },
            });
        }else{   //邮箱注册提交表单
            //判断表单信息是否有误
            if (!useremail.search('@')||!useremail.search('com')){
                alert('表单填写有误！');
                return;
            }
            let dates={
                email:useremail,
                empassword:empassword
            }
            $.ajax({
                type: "POST",
                url: '/login/adduser/email',
                data: { somefield: dates, _token: '{{csrf_token()}}' },
                success: function (data) {
                    document.getElementById('resoult').innerHTML='注册成功！';
                    if (data==1) {
                        document.getElementById('resoult').innerHTML='用户已经注册过了！';
                    }
                    if (data==3) {
                        document.getElementById('resoult').innerHTML='验证码错误！';
                    }
                    document.getElementById('toasts').style.display='block';
                    setTimeout(function () {
                        document.getElementById('toasts').style.display='none';
                    },1000);
                },
                error: function (data, textStatus, errorThrown) {
                    document.getElementById('loadingToast').innerHTML='注册失败！';
                    document.getElementById('loadingToast').style.display='block';
                    setTimeout(function () {
                        document.getElementById('loadingToast').style.display='none';
                    },1000);

                },
            });
        }
    }
    function displayContent(content) {
        document.write(content);
    }

    function getcode(){

        document.getElementById('toasts').style.display='block';
        setTimeout(function () {
            document.getElementById('toasts').style.display='none';
        },1000);
        var int=self.setInterval("clock()",1000);
        document.getElementById('getcode').style.color='#666666';
        setTimeout(function () {
            int=window.clearInterval(int);
            document.getElementById('getcode').innerHTML='重新发送';
            document.getElementById('getcode').style.color='green';
            i=60;
        },60000)

    }

    //将等待再次发送的时间以倒计时的方式显示给用户
    function clock()
    {
        i--;
        document.getElementById("getcode").innerHTML='重新发送'+i+'秒';
    }

    //导航切换函数

</script>
@endsection
