@extends('master')
@section('title','首页')
@section('css')
    <link rel="stylesheet" type="text/css" href="/css/swiper.css" />
    <script type="text/javascript" src="/js/swiper.js"></script>
@endsection
@section('content')
    <div class="weui-cells__title">新品上架</div>


        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($preimg as $ke=>$img)
                    <div class="swiper-slide" style="width: 200px;height: 200px;" onclick="window.location.href='/product/{{$id[$ke]}}'"><img src="{{$img}}" style="height: 200px;" id="slide"></div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev" style="width: 25px;height: 20px"></div>
            <div class="swiper-button-next" style="width: 25px;height: 20px"></div>
        </div>

    <div class="weui-cells__title">商品列表</div>
    <div class="weui-cells">
        @foreach($res as $k=>$v)
            <div class="weui-cells">
              <a class="weui-cell weui-cell_access" onclick="window.location.href='/product/{{$v->id}}'">
                      <div class="weui-cell__hd"><img src="{{$v->prview_img}}" alt="" style="width:60px;margin-right:5px;display:block"></div>
                         <div class="weui-cell__bd">
                                  <p id="celltitle" style="text-indent: 2em">{{$v->info}}</p>
                             <p style="color: red;text-indent: 2em">{{$v->price}}</p>
                         </div>
                            <div class="weui-cell__ft"></div>
                          </a>
                 </div>
        @endforeach
    </div>
@endsection
@section('my-js')
    <script>
        var mySwiper = new Swiper('.swiper-container',
            {
                speed:2500,//播放速度
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
    </script>
@endsection