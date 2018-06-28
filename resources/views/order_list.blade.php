@extends('master')
@section('title','订单列表')
@section('content')
 <div class="weui-cells__title">用户:<span style="color: green"><?php echo session('user');?></span>的订单列表</div>
@foreach($orderid as $kk=>$val)
            <div class="weui-form-preview" style="margin-top: 30px;display: block;border: #cccccc solid 1px;margin: 15px;box-shadow: rgba(220,220,220,0.6) 0px 15px 15px" id="{{$val}}">
                <div class="weui-form-preview__hd" style="border-bottom: dashed #cccccc 1px">
                    <label class="weui-form-preview__label">付款金额</label>
                    <em class="weui-form-preview__value" style="color: red">¥{{$total[$kk]}}</em>
                </div>
                <div class="weui-form-preview__bd">
                    <p>
                        <label class="weui-form-preview__label">商品</label>
                        <div>
                        @foreach($product[$kk] as $k=>$v)
                            @if($k<3)
                        <span class="weui-form-preview__value">{{$v->info}}&nbsp;&nbsp;*{{$count[$kk][$k]}}</span>
                            @endif
                        @endforeach
                            <span class="weui-form-preview__value" onclick="location.href='/order/{{$val}}'" style="color: green">查看更多...</span>
                    </div>
                    </p>
                    <p>
                        <label class="weui-form-preview__label">订单编号</label>
                        <span class="weui-form-preview__value" style="color: black">{{$val}}</span>
                    </p>
                    <p>
                        <label class="weui-form-preview__label">订单状态</label>
                        <span class="weui-form-preview__value">@if($state[$kk]=='pay')已支付@elseif($state[$kk]=='no pay')未支付@else已支付，已发货@endif</span>
                    </p>
                    <p>
                        <label class="weui-form-preview__label">创建时间</label>
                        <span class="weui-form-preview__value">{{$created[$kk]}}</span>
                    </p>
                </div>
                <div class="weui-form-preview__ft" style="border-top: dashed #cccccc 1px">
                    <a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="location.href='/order/{{$val}}'">@if($state[$kk]=='pay')查看详情@elseif($state[$kk]=='no pay')去支付@else查看详情@endif</a>
                    <a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="delorder('{{$val}}')" style="color: red">删除</a>
                </div>
            </div>


                        
                    </div>
    @endforeach
 <div style="padding-bottom: 40px"></div>
 <div id="dialog1" style="display: none;">
     <div class="weui-mask"></div>
     <div class="weui-dialog">
         <div class="weui-dialog__hd"><strong class="weui-dialog__title">提示</strong></div>
         <div class="weui-dialog__bd">确认要删除吗?</div>
         <div class="weui-dialog__ft" id="delid">


         </div>
     </div>
 </div>
@endsection
@section('my-js')
    <script>
        function delorder(id='') {
            let confirm=document.getElementById('dialog1').style.display;
            if (confirm=='block'){
                document.getElementById('dialog1').style.display='none';
                document.getElementById('delid').innerHTML='';
            }else {
                document.getElementById('dialog1').style.display='block';
                document.getElementById('delid').innerHTML=' <a onclick="delorder()" class="weui-dialog__btn weui-dialog__btn_default">取消</a><a class="weui-dialog__btn weui-dialog__btn_primary" id="delss">删除</a>';
                $("#delss").attr("onclick","del('"+id+"');");
            }
        }
        function del(id) {
            $.ajax({
                url:'/delorder/'+id,
                type:'GET',
                success:function (data) {
                    if (data=='ok'){
                        document.getElementById('dialog1').style.display='none';
                        document.getElementById('resoult').innerHTML='删除成功!';
                        document.getElementById('toasts').style.display='block';
                        setTimeout(function () {
                            document.getElementById(id).style.display='none';
                            document.getElementById('toasts').style.display='none';
                            document.getElementById('resoult').innerHTML='已发送!';
                        },1000);
                    }
                    console.log(data);

                },
                error:function (data,status,tst) {
                    console.log(data);
                    document.getElementById('resoult').innerHTML='更改失败!';
                    document.getElementById('toasts').style.display='block';
                    setTimeout(function () {
                        document.getElementById('toasts').style.display='none';
                        document.getElementById('resoult').innerHTML='已发送!';
                    },1000)
                }
            })
        }
    </script>
@endsection