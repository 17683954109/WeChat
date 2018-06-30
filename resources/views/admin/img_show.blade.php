@extends('admin.master')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 图片展示 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l"><a onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a></span>
            <span class="r">共有数据：<strong>{{$num}}</strong> 条</span>
            <span style="color: red;display: none" id="toasts"></span>
        </div>
        <div class="portfolio-content">
            <ul class="cl portfolio-area">
                @foreach($res as $k=>$v)
                <li class="item">
                    <div class="portfoliobox">
                        <input class="checkbox" name="imgid" type="checkbox" onclick="add({{$v->id}})">
                        <div class="picbox"><a data-lightbox="gallery"><img src="{{$v->address}}"></a></div>
                        <div class="textbox">图片ID : {{$v->id}}</div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
<script>
    let ids=[];
    function add(id) {
        for(let i=0;i<ids.length;i++){
            if (ids[i]==id){
                return;
            }
        }
        ids.push(id);
    }
    function datadel() {

        if (ids.length==0){
            alert('请选择删除项!');
            return;
        }

        $.ajax({
            type:'GET',
            url:'/admin/imgdel',
            datatype:'json',
            data:{products:ids+''},
            success:function (data) {
                document.getElementById('toasts').innerHTML='删除成功!';
                document.getElementById('toasts').style.display='block';
                // alert('添加成功!');
                setTimeout(function () {
                    document.getElementById('toasts').style.display='none';
                    document.getElementById('toasts').innerHTML='';
                },1000);
                location.reload();
            },
            error:function (data,status,txt) {
                document.getElementById('toasts').innerHTML='删除失败!';
                document.getElementById('toasts').style.display='block';
                // alert('添加成功!');
                setTimeout(function () {
                    document.getElementById('toasts').style.display='none';
                    document.getElementById('toasts').innerHTML='';
                },1000)
                location.reload();
            }
        })
    }
</script>
@endsection