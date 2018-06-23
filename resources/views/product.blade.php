@extends('master')
@section('title','商品页')
@section('css')
    <link rel="stylesheet" type="text/css" href="/css/swiper.css" />
    <script type="text/javascript" src="/js/swiper.js"></script>
    @endsection
@section('content')

    {{--@foreach($res as $product)--}}
    <div style="width: 100%;margin: 0 auto;text-align: center;margin-top: 15px;height: 280px;overflow: hidden;margin-top: 15px;position: relative">
        <div id="ss{{$res->id}}" style="width: 100%;margin: 0 auto;text-align: center;margin-top: 15px;height: 260px;margin-top: 15px">

            <div id="img" style="width: 100%;margin: 0 auto;padding: 0;height: 220px;position: relative">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($preimg as $img)
                            <div class="swiper-slide" style="width: 200px;height: 200px;"><img src="{{$img->address}}" style="height: 200px;" id="slide"></div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev" style="width: 25px;height: 20px"></div>
                    <div class="swiper-button-next" style="width: 25px;height: 20px"></div>
                    {{--<div class="swiper-scrollbar"></div>--}}
                </div>
            </div>





            <p id="sli" style="color: black;text-align: left;text-indent: 2em;height: 40px;line-height: 40px;color: #FFFFFF;background: rgba(25,25,25,0.3);">{{$res->info}}</p>

        </div>
        {{--@endforeach--}}
        <span style="color: red;font-size: 18px;position: absolute;right: 15px;bottom: 10px" id="price">￥{{$res->price}}</span>
    </div>
        <div style="width: 100%-30px;margin: 0 auto;text-align: left;text-indent: 2em;font-size: 14px;padding: 15px">
            <p>{{$det->content}}...</p>
        </div>

    <div class="weui-cells__title">支付方式</div>
    <div class="weui-cells weui-cells_radio">
        <label class="weui-cell weui-check__label" for="x11">
            <div class="weui-cell__bd">
                <p>微信支付</p>
            </div>
            <div class="weui-cell__ft">
                <input type="radio" class="weui-check" name="radio1" id="x11" checked="checked">
                <span class="weui-icon-checked"></span>
            </div>
        </label>
        <label class="weui-cell weui-check__label" for="x12">

            <div class="weui-cell__bd">
                <p>支付宝支付</p>
            </div>
            <div class="weui-cell__ft">
                <input type="radio" name="radio1" class="weui-check" id="x12">
                <span class="weui-icon-checked"></span>
            </div>
        </label>
    </div>


    <label for="weuiAgree" class="weui-agree">
        <input id="weuiAgree" type="checkbox" class="weui-agree__checkbox"checked="checked">
        <span class="weui-agree__text">
        阅读并同意<a href="javascript:void(0);">《相关条款》</a>
    </span>
    </label>
<div style="width: 100%;height: 80px;position: fixed;left: 0;bottom: 0;background: #FFFFFF;z-index: 90">
    <div class="weui-btn-area" style="display: flex">
        <a class="weui-btn weui-btn_primary" id="showTooltips" style="width: 48%;flex-grow: 1;margin: 0;padding: 0;background: #FFFFFF;border: none;border-radius: 0;color: black;" onclick="addcart()">加入购物车</a>
        <a class="weui-btn weui-btn_primary" id="prcs" style="width: 48%;flex-grow: 1;margin: 0;padding: 0;margin-left: 5%" onclick="tocart()">立即购买</a>
    </div>
    </div>

    <div style="padding-bottom: 80px;padding-left: 16px">
        <p>购买数量:</p>
        <button id="btn1" value="-" style="width: 25px;height: 25px;display: inline-block;font-size: 18px">-</button>
        <input type="number" style="width: 40px;height: 20px;display: inline-block;text-align: center" value="1" id="addnum"onfocusout="testnum()">
        <button id="btn2" value="+" style="width: 25px;height: 25px;display: inline-block;font-size: 18px">+</button>
        <span style="color: red;font-size: 18px" id="prc"></span>
    </div>

@endsection
@section('my-js')
    <script>
       window.onload=function (){

           let oBtn1=document.getElementById('btn1');
           let oBtn2=document.getElementById('btn2');
           let addnum=document.getElementById('addnum');
           let seaws=addnum.value*{{$res->price}};
           document.getElementById('prc').innerHTML='￥'+seaws.toFixed(1);
           if ('oninput' in addnum){
               addnum.addEventListener('input',getprice,false);
           }else{
               addnum.onpropertychange=getprice;
           }
           function getprice(){
               // if (addnum.value<1){
               //     addnum.value=1;
               // }
               let seaws=addnum.value*{{$res->price}};
               document.getElementById('prc').innerHTML='￥'+seaws.toFixed(1);
           }
           oBtn1.onclick=function () {
               if (addnum.value==1){
                   return;
               }
               addnum.value--;
               let sasasa=addnum.value*{{$res->price}};
               document.getElementById('prc').innerHTML='￥'+sasasa.toFixed(1);
           }
           oBtn2.onclick=function () {
               addnum.value++;
               let sasas=addnum.value*{{$res->price}};
               document.getElementById('prc').innerHTML='￥'+sasas.toFixed(1);
           }
           var mySwiper = new Swiper('.swiper-container',
                              {
                                  speed:2000,//播放速度
                                  autoHeight:true,
                                  loop:true,//是否循环播放
                                  setWrapperSize:true,
                                  autoplay: {
                                      disableOnInteraction: false,
                                  },
                                  pagination:  '.swiper-pagination',//分页
                                  effect : 'slide',//动画效果
                              }
           );
       };
       document.title=document.getElementById('sli').innerHTML;
       $('.titles').html(document.title);
        function addcart() {
            // let tip=document.getElementById('dialog1');
            let tips=document.getElementById('ssssss');
            let numsss=document.getElementById('addnum').value;
            $.ajax({
                url:'/cart/add/{{$res->id}}/'+numsss,
                type:'GET',
                success:function (data) {

                    console.log(data);
                    if (data=='ok'){
                        document.getElementById('resoult').innerHTML='添加成功!';
                        document.getElementById('toasts').style.display='block';
                    // alert('添加成功!');
                        setTimeout(function () {
                            document.getElementById('toasts').style.display='none';
                            document.getElementById('resoult').innerHTML='已发送!';
                        },1000)
                    }
                },
                error:function (data,status,txt) {
                    document.getElementById('resoult').innerHTML='添加失败!';
                    document.getElementById('toasts').style.display='block';
                    // alert('添加成功!');
                    setTimeout(function () {
                        document.getElementById('toasts').style.display='none';
                        document.getElementById('resoult').innerHTML='已发送!';
                    },1000)
                    console.log(data);

                }
            })
        }
        function tocart() {
            let numsse=document.getElementById('addnum').value;
            window.location.href='/cart/pay/{{$res->id}}/'+numsse;
        }
        function testnum() {
            let adnum=document.getElementById('addnum');
            if (adnum.value<1){
                adnum.value=1;
            }
            let seawss=adnum.value*{{$res->price}};
            document.getElementById('prc').innerHTML='￥'+seawss.toFixed(1);
        }
    </script>
@endsection