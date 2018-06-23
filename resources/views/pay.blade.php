@extends('master')
@section('title','订单确认')
@section('content')
    <div class="weui-form-preview" style="padding-top: 30px">
        <div class="weui-form-preview__hd">
            <label class="weui-form-preview__label">付款金额</label>
            <em class="weui-form-preview__value" id="total" style="color: red">¥{{$total}}</em>
        </div>
        <div class="weui-form-preview__bd">
            <p>
                <label class="weui-form-preview__label">商品</label>
                <span class="weui-form-preview__value">{{$price->info}}</span>
            </p>
            <p>
                <label class="weui-form-preview__label">购买数量</label>
                <span class="weui-form-preview__value">
            <button id="btn1" value="-" style="width: 25px;height: 25px;display: inline-block;font-size: 18px">-</button>
            <input type="number" style="width: 40px;height: 20px;display: inline-block;text-align: center" value="{{$num}}" id="addnum">
            <button id="btn2" value="+" style="width: 25px;height: 25px;display: inline-block;font-size: 18px">+</button></span>
            </p>
            <p>
                <label class="weui-form-preview__label">收件人</label>
                <span class="weui-form-preview__value" style="color: red">{{$user}}</span>
            </p>
        </div>
        <div class="weui-form-preview__ft">
            <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="javascript:">立即支付</a>
        </div>
    </div>
@endsection
@section('my-js')
    <script>
    window.onload=function (){
    let oBtn1=document.getElementById('btn1');
    let oBtn2=document.getElementById('btn2');
    let addnum=document.getElementById('addnum');
    let total=document.getElementById('total');
    if ('oninput' in addnum){
        addnum.addEventListener('input',getaddnum,false);
    }else{
        addnum.onpropertychange=getaddnum;
    }
    function getaddnum(){
        let prcss=addnum.value*{{$price->price}};
        total.innerHTML='￥'+prcss.toFixed(1);
    }
    oBtn1.onclick=function () {
    if (addnum.value==1){
    return;
    }
    addnum.value--;
    let swasas=addnum.value*{{$price->price}};
    total.innerHTML='￥'+swasas.toFixed(1)
    }
    oBtn2.onclick=function () {
    addnum.value++;
    let swasa=addnum.value*{{$price->price}};
        total.innerHTML='￥'+swasa.toFixed(1);
    }}
    </script>
@endsection