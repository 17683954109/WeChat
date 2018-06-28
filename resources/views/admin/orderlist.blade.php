@extends('admin.master')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> 订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="r">共有数据：<strong id="nums">{{count($res)}}</strong> 条</span> </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">订单号</th>
                    <th width="80">下单用户</th>
                    <th width="80">下单时间</th>
                    <th width="75">收货人</th>
                    <th width="100">收货地址</th>
                    <th width="50">联系电话</th>
                    <th width="60">订单状态</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody id="output">
                @foreach($res as $k=>$v)
                    <tr class="text-c">
                        <td>{{$v->id}}</td>
                        <td class="text-l">{{$v->order_id}}</td>
                        <td>{{$v->user}}</td>
                        <td>{{$v->created_at}}</td>
                        <td>{{$info[$k]->name}}</td>
                        <td>{{$info[$k]->address}}</td>
                        <td>{{$info[$k]->phone}}</td>
                        <td class="td-status"><span class="label @if($v->state=='no pay') label-error @else label-success @endif radius">@if($v->state=='pay')未发货@elseif($v->state=='no pay')未支付@else已完成@endif</span></td>
                        <td class="f-14 td-manage"> <a style="text-decoration:none" class="ml-5" onClick="cateEdit('订单发货','/admin/orderinfo/{{$v->order_id}}','10001')" href="javascript:;" title="去发货"><i class="Hui-iconfont">&#xe669;</i></a> @if($v->state!='pay')<a style="text-decoration:none" class="ml-5" onclick="catedelsss('{{$v->order_id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--_footer 作为公共模版分离出去-->
    <script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
    <script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script>
    <script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
    <script>
        function cateEdit(name,url,id) {
            var index=layer.open({
                type:2,
                title:name,
                content:url,
            });
            layer.full(index);
        }
        function catedelsss(id) {
            $.ajax({
                url:'/admin/order_del',
                type:'POST',
                data:{
                    id:id,
                    _token:"{{csrf_token()}}"
                },
                success:function (data) {
                    console.log(data);
                    if (data=='ok'){
                        layer.msg('删除成功!',{icon:1,time:2000});
                        setTimeout(function () {
                            location.reload();
                        },1500);
                    }
                },
                error:function (data,status,sts) {
                    console.log(data);
                    layer.msg('删除失败!',{icon:2,time:2000});
                }
            })
        }
    </script>
@endsection