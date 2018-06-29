@extends('master')
@section('title','新增收货地址')
@section('content')
    <div class="weui-cells__title">新增收货信息</div>
    <div class="weui-cells weui-cells_form">


        <div class="weui-cells__title">收件人：</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="请输入姓名" id="username"/>
                </div>
            </div>
        </div>

    <div class="weui-cells__title">联系电话:</div>
    <div class="weui-cells">

        <div class="weui-cell weui-cell_select weui-cell_select-before">
            <div class="weui-cell__hd">
                <select class="weui-select" name="select2">
                    <option value="1">+86</option>
                </select>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入号码" id="phone"/>
            </div>
        </div>
    </div>
    <div class="weui-cells__title">选择地址:</div>
    <div class="weui-cells">
        <div class="weui-cell weui-cell_select weui-cell_select-after">

            <div class="weui-cell__bd">
                <select class="weui-select" name="select2" id="city" onchange="getmin()">
                    @foreach($pro as $ke=>$va)
                    <option value="{{$va->provinceid}}">{{$va->province}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="weui-cell weui-cell_select weui-cell_select-after" style="display: none" id="cities">

            <div class="weui-cell__bd">
                <select class="weui-select" name="select2" id="citymin" onchange="getares()">

                    <option value="58">正在加载城市</option>

                </select>
            </div>
        </div>

        <div class="weui-cell weui-cell_select weui-cell_select-after" style="display: none" id="areas">

            <div class="weui-cell__bd">
                <select class="weui-select" name="select2" id="citymins">

                    <option value="58">正在加载城市</option>

                </select>
            </div>
        </div>

        <div class="weui-cells__title">详细地址：</div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="街道、门牌号" id="detail"/>
                </div>
            </div>
        </div>

    </div>
<script>
    window.onload=(getmin());
    function getmin() {
        let cityid=document.getElementById('city').value;
        $.ajax({
            url:'/cart/getcity/'+cityid,
            type:'GET',
            success:function (data) {
                if (data!=''&&data!=null){
                    if (data.length==2){
                        return;
                    }
                    document.getElementById('cities').style.display='block';
                    document.getElementById('citymin').innerHTML='';
                    data.forEach(function (e) {
                        document.getElementById('citymin').innerHTML+="<option value="+e.cityid+">"+e.city+"</option>";
                    });
                    getares();
                }
            },
            error:function (data,status,sts) {
            }
        })
    }
    function getares() {
        let cid=document.getElementById('citymin').value;
        $.ajax({
            url:'/cart/getarea/'+cid,
            type:'GET',
            success:function (data) {
                if (data!=''&&data!=null){
                    if (data.length==2){
                        return;
                    }
                    document.getElementById('areas').style.display='block';
                    document.getElementById('citymins').innerHTML='';
                    data.forEach(function (e) {
                        document.getElementById('citymins').innerHTML+="<option value="+e.areaid+">"+e.area+"</option>";
                    });
                }
            },
            error:function (data,status,sts) {
            }
        })
    }
</script>

    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" id="showTooltips" onclick="sendform()">确定</a>
    </div>
        <script>
            function sendform() {
                let names=document.getElementById('username').value;
                let phone=document.getElementById('phone').value;
                let province=document.getElementById('city').value;
                let city=document.getElementById('citymin').value;
                let area=document.getElementById('citymins').value;
                let detail=document.getElementById('detail').value;
                if (names==undefined||phone==undefined||province==undefined||city==undefined||area==undefined||detail==undefined){
                    document.getElementById('resoult').innerHTML='请认真填写!';
                    document.getElementById('toasts').style.display='block';
                    // alert('添加成功!');
                    setTimeout(function () {
                        document.getElementById('toasts').style.display='none';
                        document.getElementById('resoult').innerHTML='已发送!';
                    },1000)
                    return;
                }
                if (names==''||phone==''||province==''||city==''||area==''||detail==''){
                    document.getElementById('resoult').innerHTML='请认真填写!';
                    document.getElementById('toasts').style.display='block';
                    // alert('添加成功!');
                    setTimeout(function () {
                        document.getElementById('toasts').style.display='none';
                        document.getElementById('resoult').innerHTML='已发送!';
                    },1000)
                    return;
                }
                let dates={
                    name:names,
                    tel:phone,
                    province:province,
                    city:city,
                    area:area,
                    detail:detail,
                    _token:"{{csrf_token()}}"
                }
                $.ajax({
                    url:'/cart/addaddress',
                    type:'POST',
                    data:dates,
                    success:function (data) {
                        document.getElementById('resoult').innerHTML='添加成功!';
                        document.getElementById('toasts').style.display='block';
                        // alert('添加成功!');
                        setTimeout(function () {
                            document.getElementById('toasts').style.display='none';
                            document.getElementById('resoult').innerHTML='已发送!';
                            history.go(-1);
                        },1000)
                    },
                    error:function (data,status,sts) {
                        console.log(data);
                    }
                })
            }
        </script>
@endsection