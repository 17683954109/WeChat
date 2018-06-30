@extends('admin.master')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> 订单发货 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="r">共有商品：<strong id="nums">{{count($title)}}</strong> 件</span> </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="80">商品ID</th>
                    <th width="100">商品名称</th>
                    <th width="100">商品图片</th>
                    <th width="80">单价</th>
                    <th width="80">数量</th>
                    <th width="75">总计</th>

                </tr>
                </thead>
                <tbody id="output">
                @foreach($price as $k=>$v)
                    <tr class="text-c">
                        <td>{{$proid[$k]}}</td>
                        <td class="text-l">{{$title[$k]}}</td>
                        <td><img src="{{$image[$k]}}" style="width: 100px"/></td>
                        <td>{{$price[$k]}}元</td>
                        <td style="color: green">{{$nums[$k]}}件</td>
                        <td style="color: red">{{$nums[$k]*$price[$k]}}元</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="panel panel-default">
            <div class="panel-header">订单信息:</div>
            <div class="panel-body">
                <p>订单号：{{$order_id}}</p>
                <p>收件人：{{$collect->name}}</p>
                <p>联系电话：{{$collect->phone}}</p>
                <p>收货地址：{{$collect->address}}</p>
            </div>
        </div>


        <div class="panel panel-default" style="text-align: right">
            <div class="panel-header" id="totalprc" style="color: red">总计：{{$total}}元</div>
            <div class="panel-body">
                @if($state=='pay')
                    <p>状态：用户已支付，可以发货</p>
                        <input class="btn btn-primary radius" value="&nbsp;&nbsp;确认发货&nbsp;&nbsp;" onclick="sendChange()" id="res">
                @elseif($state=='no pay')
                    <p>状态：用户未支付，不可发货</p>
                    <input class="btn disabled radius" value="&nbsp;&nbsp;确认发货&nbsp;&nbsp;" disabled>
                @else
                    <p>状态：已发货，可以重发</p>
                    <input class="btn btn-primary radius" value="&nbsp;&nbsp;重新发货&nbsp;&nbsp;" onclick="sendChange()" id="res">
                @endif
                    </div>
        </div>
    </div>
    <script>
        function sendChange() {
            $.ajax({
                url:'/admin/orderchange',
                type:'GET',
                success:function (data) {
                    if (data=='ok'){
                        document.getElementById('res').value='发货成功';
                        setTimeout(function () {
                            location.reload();
                        },1500);
                    }else{
                        document.getElementById('res').value='发货失败';
                        setTimeout(function () {
                            document.getElementById('res').value='重试';
                        },1500);
                    }

                },
                error:function (data,status,sts) {
                    document.getElementById('res').value='发货失败';
                    setTimeout(function () {
                        document.getElementById('res').value='重试';
                    },1500);
                }
            })
        }
    </script>

@endsection