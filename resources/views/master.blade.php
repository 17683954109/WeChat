<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/pub.css" />
    <link rel="stylesheet" type="text/css" href="/css/weui.css" />
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    @yield('css')
    @yield('icon')
</head>
<body>
{{--右上角的全局菜单栏--}}
<div class="back_bar" id="back-global" style="position: fixed;z-index: 999999;background: rgba(255,255,255,1);display: block;width: 100%">
    <img class="bk_bar" src="/images/back.png" onclick="history.go(-1)">
    <p class="titles" style="font-size: 18px"></p>

    <img class="bk_menu" src="/images/Viewlist.png" onclick="shownav()">
</div>
<div class="weui-tab" style="padding-top: 50px">
    <div class="weui-navbar" id="tab_bar" style="display: none;z-index: 92;position: fixed;left: 0;top: 40px;background: rgba(25,25,25,0.7)" onclick="hidetab()">

        {{--右上角全局菜单导航--}}
        <div style="background: #FFFFFF;height:20%;overflow: hidden;position: fixed;left: 0;bottom: 0;width: 100%;z-index: 99999" id="slese">
        <div class="weui-navbar__item" id="page0" onclick="location.href='/'" style="background: rgba(255,255,255,1);text-align: left;text-indent: 3em">
            首页
        </div>
        <div class="weui-navbar__item" id="page1" onclick="location.href='/login'" style="background: rgba(255,255,255,1);text-align: left;text-indent: 3em">
            登录
        </div>
        <div class="weui-navbar__item" id="page2" onclick="location.href='/goods'" style="background: rgba(255,255,255,1);text-align: left;text-indent: 3em">
            分类
        </div>
        <div class="weui-navbar__item" id="page3" onclick="location.href='/cart/vis'" style="background: rgba(255,255,255,1);text-align: left;text-indent: 3em">
            购物车
        </div>
        <div class="weui-navbar__item" id="page3" onclick="location.href='/cart/order_list'" style="background: rgba(255,255,255,1);text-align: left;text-indent: 3em">
            我的订单
        </div>
        <?php
        if (session('user')!=''&&session('user')!=null){
            echo '<div class="weui-navbar__item" id="page4" onclick="shows(\'page3\')" style="background: rgba(255,255,255,1);text-align: left;text-indent: 3em">用户:'.session("user").'</div>';
        }else{
            echo '<div class="weui-navbar__item" id="page4" onclick="shows(\'page3\')" style="background: rgba(255,255,255,1);text-align: left;text-indent: 3em">个人中心</div>';
        }

        ?>
        </div>
    </div>
</div>
<div id="toasts" style="display: none;z-index: 999999;position: fixed;width: 100%;height: 100%;left: 0;bottom: 0">
    <div class="weui-mask_transparent" style="z-index: 999999;"></div>
    <div class="weui-toast" style="z-index: 999999;">
        <i class="weui-icon-success-no-circle weui-icon_toast" style="z-index: 999999;"></i>
        <p class="weui-toast__content" id="resoult" style="z-index: 999999;">已发送！</p>
    </div>
</div>




<script>


    let isas=20;
    function shownav() {
        let info=document.getElementById('tab_bar').style.display;
        document.getElementById('tab_bar').style.height='100%';
        if (info=='none'){
            if (isas!=20){
                return;
            }
            document.getElementById('tab_bar').style.display='block';
            saws=setInterval(function () {
                if (isas==50){
                    saws=window.clearInterval(saws);
                    isas=20;
                    return;
                }
                document.getElementById('slese').style.height=isas+'%';
                isas++;
            },10);
        }else{
            if (isas!=20){
                return;
            }
            document.getElementById('tab_bar').style.display='none';
        }
    }
    function hidetab() {
        document.getElementById('tab_bar').style.display='none';
    }
    function shows(id){
        if (id=='page1') {
            var page1=document.getElementById('page1');
            var page2=document.getElementById('page2');
            var page3=document.getElementById('page3');
            page1.className='weui-navbar__item weui-bar__item_on';
            document.getElementById('pa1').style.display='block';
            page2.className='weui-navbar__item';
            document.getElementById('pa2').style.display='none';
            page3.className='weui-navbar__item';
            document.getElementById('pa3').style.display='none';
            document.getElementById('tab_bar').style.display='none';
        }
        if(id=='page2'){
            var page1=document.getElementById('page1');
            var page2=document.getElementById('page2');
            var page3=document.getElementById('page3');
            page2.className='weui-navbar__item weui-bar__item_on';
            document.getElementById('pa2').style.display='block';
            page1.className='weui-navbar__item';
            document.getElementById('pa1').style.display='none';
            page3.className='weui-navbar__item';
            document.getElementById('pa3').style.display='none';
            document.getElementById('tab_bar').style.display='none';
        }
        if(id=='page3'){
            var page1=document.getElementById('page1');
            var page2=document.getElementById('page2');
            var page3=document.getElementById('page3');
            page3.className='weui-navbar__item weui-bar__item_on';
            document.getElementById('pa3').style.display='block';
            page1.className='weui-navbar__item';
            document.getElementById('pa1').style.display='none';
            page2.className='weui-navbar__item';
            document.getElementById('pa2').style.display='none';
            document.getElementById('tab_bar').style.display='none';
        }
    }


    {{--根据页面标题改变navbar的标题--}}

    $('.titles').html(document.title);

    //根据标题改变右上角全局导航菜单的高亮显示
    if (document.title=='登录页面') {
        document.getElementById('page1').style.color='green';
    }
    if (document.title=='分类') {
        document.getElementById('page2').style.color='green';
    }
    if (document.title=='购物车'||document.title=='订单确认') {
        document.getElementById('page3').style.color='green';
    }
    if (document.title=='个人中心') {
        document.getElementById('page4').style.color='green';
    }
    if (document.title=='注册页面') {
        document.getElementById('page0').style.color='green';
    }
    $(document).ready(function(){
        var p=0,t=0;
        $(window).scroll(function(e){
            p = $(this).scrollTop();

            if(t<=p){
                document.getElementById('back-global').style.display='none'
            }else{
                document.getElementById('back-global').style.display='block'
            }
            setTimeout(function(){t = p;},0);
        });
    });
</script>
@yield('content')
</body>
@yield('my-js')
</html>
<script type="text/javascript" src="/js/pub.js"></script>