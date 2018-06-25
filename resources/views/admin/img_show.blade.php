@extends('admin.master')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 图片管理 <span class="c-gray en">&gt;</span> 图片展示 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a href="javascript:;" onclick="edit()" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe6df;</i> 编辑</a> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> </span> <span class="r">共有数据：<strong>{{$num}}</strong> 条</span> </div>
        <div class="portfolio-content">
            <ul class="cl portfolio-area">
                @foreach($res as $k=>$v)
                <li class="item">
                    <div class="portfoliobox">
                        <input class="checkbox" name="" type="checkbox" value="">
                        <div class="picbox"><a href="temp/big/keting.jpg" data-lightbox="gallery" data-title="客厅1"><img src="{{$v->address}}"></a></div>
                        <div class="textbox">图片ID : {{$v->id}}</div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection