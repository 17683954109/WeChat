@extends('admin.master')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 资讯管理 <span class="c-gray en">&gt;</span> 资讯列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l"><a href="javascript:;" onclick="catedelsss()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                <a class="btn btn-primary radius" onclick="changemode('s')" id="ser"><i class="Hui-iconfont">&#xe600;</i> 显示子分类</a></span>
            <span class="r">共有数据：<strong id="nums">{{count($main)}}</strong> 条</span> </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" onclick="selectssse()"></th>
                    <th width="80">ID</th>
                    <th width="100">名称</th>
                    <th width="80">备注</th>
                    <th width="80">创建时间</th>
                    <th width="120">更新时间</th>
                    <th width="75">分类级别</th>
                    <th width="60">发布状态</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody id="output">
                @foreach($main as $k=>$v)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{$v->class_id}}" name="delidsse" onchange="getse({{$v->class_id}})" id="{{$v->class_id}}"></td>
                    <td>{{$v->class_id}}</td>
                    <td class="text-l">{{$v->pro_name}}</td>
                    <td>{{$v->preview}}</td>
                    <td>{{$v->created_at}}</td>
                    <td>{{$v->updated_at}}</td>
                    <td>主分类</td>
                    <td class="td-status"><span class="label label-success radius">已发布</span></td>
                    <td class="f-14 td-manage"> <a style="text-decoration:none" class="ml-5" onClick="cateEdit('分类编辑','/admin/cateEdit/{{$v->class_id}}/m','10001')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onclick="catedelsss({{$v->class_id}})" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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
    <script type="text/javascript">
        function selectssse() {
            var checked=$('input:checkbox[name=delidsse]').attr('checked');
            if (checked=='checked'){
                $('input:checkbox[name=delidsse]').attr('checked',false);
            }else{
                $('input:checkbox[name=delidsse]').attr('checked','checked');
            }
        }
        function getse(id){
            var checked=$('#'+id).attr('checked');
            if (checked=='checked'){
                $('#'+id).attr('checked',false);
            }else{
                $('#'+id).attr('checked','checked');
            }
        }
        let catemode=false;
        function changemode(mm=''){
            if (mm=='s'){
                catemode=!catemode;
            }
            let stat='clas';
            if (catemode==false){
                stat='main';
            }
            $.ajax({
                url:'/admin/show/'+stat,
                type:'GET',
                success:function (data) {
                    document.getElementById('output').innerHTML='';
                    document.getElementById('nums').innerHTML=data.length;
                    data.forEach(function (e) {
                        let sys;
                        let si;
                        let rt;
                        if (e.pro_name){
                            sys=e.pro_name;
                            si='主分类';
                            rt='m'
                            document.getElementById('ser').innerHTML="<i class=\"Hui-iconfont\">&#xe600;</i> 显示子分类";
                        }else{
                            sys=e.class_name;
                            si='子分类';
                            rt='z'
                            document.getElementById('ser').innerHTML="<i class=\"Hui-iconfont\">&#xe600;</i> 显示主分类";
                        }
                        document.getElementById('output').innerHTML+="<tr class=\"text-c\">\n" +
                            "                    <td><input type=\"checkbox\" value="+e.class_id+" name=\"delidsse\" id='"+e.class_id+"' onchange='getse("+e.class_id+")'></td>\n" +
                            "                    <td>"+e.class_id+"</td>\n" +
                            "                    <td class=\"text-l\">"+sys+"</td>\n" +
                            "                    <td>"+e.preview+"</td>\n" +
                            "                    <td>"+e.created_at+"</td>\n" +
                            "                    <td>"+e.updated_at+"</td>\n" +
                            "                    <td>"+si+"</td>\n" +
                            "                    <td class=\"td-status\"><span class=\"label label-success radius\">已发布</span></td>\n" +
                            "                    <td class=\"f-14 td-manage\"> <a style=\"text-decoration:none\" href=\"javascript:;\" class=\"ml-5\" onClick=\"cateEdit('分类编辑','/admin/cateEdit/"+e.class_id+"/"+rt+"\',\'10001\')\" title=\"编辑\"><i class=\"Hui-iconfont\">&#xe6df;</i></a> <a style=\"text-decoration:none\" class=\"ml-5\" onClick=\"catedelsss('"+e.class_id+"')\" href=\"javascript:;\" title=\"删除\"><i class=\"Hui-iconfont\">&#xe6e2;</i></a></td>\n" +
                            "                </tr>"
                    })
                },
                error:function (data,status,sts) {
                    console.log(data);
                }
            })
        }
        function cateEdit(name,url,id) {
            var index=layer.open({
                type:2,
                title:name,
                content:url,
            });
            layer.full(index);
        }
        function catedelsss(id='') {
            var item_arrss=[];
            $('input:checkbox[name=delidsse]').each(function(index,el) {
                if ($(this).attr('checked') == 'checked'){
                    item_arrss.push($(this).attr('id'));
                }
            });
            if (item_arrss.length==0&&id==''){
                layer.msg('请选择删除项!',{icon:2,time:2000});
                // alert('添加成功!');
                return;
            }
            if (id!=''){
                item_arrss=[];
                item_arrss.push(id);
            }
            console.log(item_arrss);
            let stat='clas';
            if (catemode==false){
                stat='main';
            }
            $.ajax({
                url:'/admin/catedel/'+stat,
                type:'GET',
                data:{products:item_arrss+''},
                success:function (data) {
                    console.log(data);
                    layer.msg('删除成功!',{icon:1,time:2000});
                    changemode();
                },
                error:function (data,status,txt) {
                    console.log(data);
                    layer.msg('删除失败!',{icon:2,time:2000});
                }
            })
        }

    </script>
@endsection