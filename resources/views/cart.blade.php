@extends('master')
@section('title','购物车')
@section('css')
@endsection
@section('content')
    <div class="weui-cells__title">商品列表<a style="color: green;float: right" onclick="selectAll()" id="selects">全选</a></div>
    <div class="weui-cells weui-cells_checkbox" style="text-align: left;padding-bottom: 80px" id="mys">
        <script>
            var price_arr=[];
            var num=[];
            var idss=[];
        </script>
        @if($cart!=null&&$img!=null&&$price!=null&&$num!=null&&$id!=null&&$prctotal!=null)
    @foreach($cart as $car=>$value)

            <div class="weui-cell">
                <div class="weui-cell__hd" style="width: 50px;height: 50px;text-align: center">
                    <label for="{{$id[$car]}}" style="width: 100%;height: 100%">
                    <input type="checkbox" class="weui-check" name="checksds" id="{{$id[$car]}}" style="margin: 0 auto;margin-top: 17px">
                    <i class="weui-icon-unchecked" style="margin: 0 auto;margin-top: 17px"></i>
                    </label>
                </div>
                <div class="weui-cell__bd">

                    <div class="weui-cells" style="z-index: 10;" onclick="location.href='/product/{{$id[$car]}}'">
                        <a class="weui-cell weui-cell_access">
                            <div class="weui-cell__hd"><img src="{{$img[$car]->address}}" style="width:60px;margin-right:5px;display:block"></div>
                            <div class="weui-cell__bd">
                                <p id="celltitle">{{$value->info}}</p>
                                <span style="font-size: 12px;color: red" id="s{{$id[$car]}}">单价:￥{{$price[$car]->price}}</span>
                                <span style="font-size: 12px;color: #666666" id="nums{{$id[$car]}}">数量:{{$num[$car]}}</span><br/>
                                <span style="font-size: 12px;color: #666666" id="tot{{$id[$car]}}">总价:￥{{$prctotal[$car]}}</span>
                            </div>
                            <div class="weui-cell__ft"></div>
                        </a>
                    </div>
<script>
    price_arr.push({'{{$id[$car]}}':{{$price[$car]->price}}});
    num.push({'{{$id[$car]}}':{{$num[$car]}}});
    idss.push({{$id[$car]}});
</script>
                </div>
            </div>
            <div style="width: 100%;margin: 0 auto;padding: 0;text-align: left">
                <a onclick="edit('ss{{$id[$car]}}')" style="border: none;background: none;margin-left: 20%;color: green;font-size: 12px">编辑数量</a>
            </div>
<div style="width: 100%-25px;margin: 0 auto;padding: 0;text-align: right;padding-right: 25px;vertical-align: top;display: none;margin-bottom: 30px" id="ss{{$id[$car]}}">
    <a style="border: none;background: none;margin-left: 20%;color: #666666;font-size: 12px;margin-right: 10px" onclick="delcart({{$id[$car]}})">删除商品</a>
    <button id="btn1" value="-" style="width: 20px;height: 20px;display: inline-block;font-size: 16px;line-height: 20px;vertical-align: top" onclick="upset('{{$id[$car]}}')">-</button>
    <input type="number" style="width: 40px;height: 15px;display: inline-block;text-align: center;vertical-align: top" value="{{$num[$car]}}" id="num{{$id[$car]}}" onfocusout="testnum({{$id[$car]}})" onfocus="testnum({{$id[$car]}},'ss')">
    <button id="btn2" value="+" style="width: 20px;height: 20px;display: inline-block;font-size: 16px;line-height: 20px;vertical-align: top" onclick="downset('{{$id[$car]}}')">+</button></div>



    @endforeach

            @else
        <p style="text-align: center;width: 100%;margin: 0 auto;padding: 0">空空如也...</p>
            @endif
    </div>
    <div style="width: 100%;height: 80px;position: fixed;left: 0;bottom: 0;background: #FFFFFF;z-index: 90">
        <p id="prcss" style="color: red;font-size: 14px;height: 10px;text-align: right;padding-right: 30px">总计:￥0.00</p>
        <div class="weui-btn-area" style="display: flex">
            <a class="weui-btn weui-btn_primary" id="showTooltips" style="width: 48%;flex-grow: 1;margin: 0;padding: 0;background: #FFFFFF;border: none;border-radius: 0;color: black;" onclick="delcart()">删除</a>
            <a class="weui-btn weui-btn_primary" id="prcs" style="width: 48%;flex-grow: 1;margin: 0;padding: 0;margin-left: 5%" onclick="topay()">结算</a>
        </div>
    </div>
@endsection
@section('my-js')
    <script>
        let totprc=0;
        let addprc=[];
        function selectAll(){
                var checked=$('input:checkbox[name=checksds]').attr('checked');
                if (checked=='checked'){
                    $('input:checkbox[name=checksds]').attr('checked',false);
                    $('input:checkbox[name=checksds]').next().removeClass('weui-icon-checked');
                    $('input:checkbox[name=checksds]').next().addClass('weui-icon-unchecked');
                    document.getElementById('selects').innerHTML='全选';
                    document.getElementById('prcss').innerHTML='总计:￥0.0';
                }else{
                    $('input:checkbox[name=checksds]').attr('checked','checked');
                    gettotal();
                    $('input:checkbox[name=checksds]').next().removeClass('weui-icon-unchecked');
                    $('input:checkbox[name=checksds]').next().addClass('weui-icon-checked');
                    document.getElementById('selects').innerHTML='全不选';
                }
        }
        function gettotal() {
             var item_arr=[];
            $('input:checkbox[name=checksds]').each(function(index,el) {
                if ($(this).attr('checked') == 'checked'){
                    item_arr.push($(this).attr('id'));
                    let price=price_arr[$(this).attr('id')];
                    let nums=num[$(this).attr('id')];
                    let totalprice=price*nums;
                    console.log('start checked');
                }
            });
            if (item_arr.length==0) {
                document.getElementById('prcss').innerHTML='总计:￥0.0';
                return;
            }
            $.ajax({
                url:'/cart/getprice/'+item_arr,
                type:'GET',
                success:function(data){
                    console.log(data);
                    document.getElementById('prcss').innerHTML='总计:￥'+data.toFixed(1);
                },
                error:function(data,status,tst){
                    console.log(data)
                }
            })
            
            if (document.getElementById('prcss').innerHTML=='总计:￥-0.0'){
                document.getElementById('prcss').innerHTML='总计:￥0.0';
            }
        }
        //  防止用户数量输入负数或0
        function testnum(id,mode='') {
            let asasa=document.getElementById('num'+id);
            if (mode==''){
                if (asasa.value<1){
                    asasa.value=1;
                    document.getElementById('nums'+id).innerHTML='数量:'+asasa.value;
                }
            }
            let pricess;
            price_arr.forEach(function (e) {
                if (e[id]){
                    pricess=e[id];
                }
            })
            changenum(id,document.getElementById('num'+id).value);
            document.getElementById('nums'+id).innerHTML='数量:'+asasa.value;
            let total=document.getElementById('num'+id).value*pricess;
            document.getElementById('tot'+id).innerHTML='总价:￥'+total.toFixed(1);
            gettotal();
        }

        //  更改数量数据库异步同步方法
        function changenum(id,num='') {
            console.log(num)
            if (num==''){

            }else{
                $.ajax({
                    url:'/cart/change/'+id+'/'+num,
                    type:'GET',
                    success:function (data) {
                        console.log(data);
                    },
                    error:function (data,status,txt) {
                        document.getElementById('resoult').innerHTML='更改失败!';
                        document.getElementById('toasts').style.display='block';
                        setTimeout(function () {
                            document.getElementById('toasts').style.display='none';
                            document.getElementById('resoult').innerHTML='已发送!';
                        },1000)
                        console.log(data);

                    }
                })
            }

        }

        //  点击数量减少方法
        function upset(id) {
            if (document.getElementById('num'+id).value==1){
                return;
            }
            let pricess;
            document.getElementById('num'+id).value--;
           price_arr.forEach(function (e) {
              if (e[id]){
                  pricess=e[id];
              }
           })
            changenum(id,document.getElementById('num'+id).value);
            let total=document.getElementById('num'+id).value*pricess;
            document.getElementById('tot'+id).innerHTML='总价:￥'+total.toFixed(1);
            document.getElementById('nums'+id).innerHTML='数量:'+document.getElementById('num'+id).value;
            gettotal();
        }

        //  点击数量增加方法
        function downset(id) {
            let pricess;
            price_arr.forEach(function (e) {
                if (e[id]){
                    pricess=e[id];
                }
            })

            document.getElementById('num'+id).value++;
            changenum(id,document.getElementById('num'+id).value);
            let total=document.getElementById('num'+id).value*pricess;
            document.getElementById('tot'+id).innerHTML='总价:￥'+total.toFixed(1);
            document.getElementById('nums'+id).innerHTML='数量:'+document.getElementById('num'+id).value;
            gettotal();

        }

        //  购物车结算方法
        function topay() {
            var item_arr=[];
            $('input:checkbox[name=checksds]').each(function(index,el) {
                if ($(this).attr('checked') == 'checked'){
                    item_arr.push($(this).attr('id'));
                }
            });
            console.log(item_arr)
            if (item_arr.length==0){
                document.getElementById('resoult').innerHTML='请选择结算项!';
                document.getElementById('toasts').style.display='block';
                // alert('添加成功!');
                setTimeout(function () {
                    document.getElementById('toasts').style.display='none';
                    document.getElementById('resoult').innerHTML='已发送!';
                },1000)
                return;
            }
            location.href='/cart/order/'+item_arr;
        }

        //  商品数量编辑框显示方法
        function edit(id){
            if (document.getElementById(id).style.display=='none'){
                document.getElementById(id).style.display='block';
                if (window.innerWidth)
                    winWidth = window.innerWidth;
                else if ((document.body) && (document.body.clientWidth))
                    winWidth = document.body.clientWidth;
                if (window.innerHeight)
                    winHeight = window.innerHeight;
                else if ((document.body) && (document.body.clientHeight))
                    winHeight = document.body.clientHeight;
                if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth)
                {
                    winHeight = document.documentElement.clientHeight;
                    winWidth = document.documentElement.clientWidth;
                }
                let idnum=idss[(idss.length)-1];
                if (id=='ss'+idnum){
                    console.log('sss')
                    window.scrollTo(winWidth,winHeight);
                }
            }else{
                document.getElementById(id).style.display='none';
            }

        }
        $('input:checkbox[name=checksds]').click(function(event) {
            var checked=$(this).attr('checked');
            if (checked=='checked'){
                $(this).attr('checked',false);
                $(this).next().removeClass('weui-icon-checked');
                $(this).next().addClass('weui-icon-unchecked');
                gettotal();
            }else{
                $(this).attr('checked','checked');
                $(this).next().removeClass('weui-icon-unchecked');
                $(this).next().addClass('weui-icon-checked');
                gettotal();
            }
        });
        </script>
    <script>

        {{--删除一整条商品方法--}}
        function delcart(id='') {
            var item_arr=[];
            $('input:checkbox[name=checksds]').each(function(index,el) {
                if ($(this).attr('checked') == 'checked'){
                    item_arr.push($(this).attr('id'));
                    let price=price_arr[$(this).attr('id')];
                    let nums=num[$(this).attr('id')];
                    let totalprice=price*nums;
                    console.log('start checked');
                }
            });
            if (id!=''){
                item_arr=[];
                item_arr.push(id);
            }
            if (item_arr.length==0){
                document.getElementById('resoult').innerHTML='请选择删除项!';
                document.getElementById('toasts').style.display='block';
                // alert('添加成功!');
                setTimeout(function () {
                    document.getElementById('toasts').style.display='none';
                    document.getElementById('resoult').innerHTML='已发送!';
                },1000)
                return;
            }
            $.ajax({
                type:'GET',
                url:'/cart/delcart',
                datatype:'json',
                data:{products:item_arr+''},
                success:function (data) {
                    console.log(data);
                    document.getElementById('resoult').innerHTML='删除成功!';
                    document.getElementById('toasts').style.display='block';
                    // alert('添加成功!');
                    setTimeout(function () {
                        document.getElementById('toasts').style.display='none';
                        document.getElementById('resoult').innerHTML='已发送!';
                    },1000);
                    location.reload('/cart/vis');
                },
                error:function (data,status,txt) {
                    console.log(data);
                    document.getElementById('resoult').innerHTML='删除失败!';
                    document.getElementById('toasts').style.display='block';
                    // alert('添加成功!');
                    setTimeout(function () {
                        document.getElementById('toasts').style.display='none';
                        document.getElementById('resoult').innerHTML='已发送!';
                    },1000)
                }
            })
        }

    </script>
@endsection