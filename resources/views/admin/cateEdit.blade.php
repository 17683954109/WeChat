@extends('admin.master')
@section('content')
    <div class="page-container">
        <div class="form form-horizontal" id="form-user-add">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    分类名称：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="@if($mode=='main'){{$res->pro_name}}@else{{$res->class_name}}@endif" placeholder="" id="proname" name="product-category-name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">分类备注：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <textarea id="content" style="height: 300px" cols="" rows="" class="textarea"  placeholder="">{{$res->preview}}</textarea>
                    <p class="textarea-numberbar" style="color: #999999">分类说明内容</p>
                </div>
            </div>







            <div class="row cl">
                <div class="col-9 col-offset-2">
                    <input class="btn btn-primary radius" value="&nbsp;&nbsp;提交&nbsp;&nbsp;" onclick="sendChange({{$res->class_id}})" id="res">
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        function sendChange(id) {
            let title=document.getElementById('proname').value;
            let content=document.getElementById('content').value;
            $.ajax({
                url:'/admin/cateChange',
                type:'POST',
                data:{
                    title:title,
                    content:content,
                    mode:"{{$mode}}",
                    id:id,
                    _token:"{{csrf_token()}}"
                },
                success:function (data) {
                    if (data=='ok'){
                        document.getElementById('res').value='修改成功!';
                    }
                    setTimeout(function () {
                        document.getElementById('res').value='提交';
                    },2000)
                },
                error:function (data,status,txt) {
                }
            })
        }
    </script>
@endsection