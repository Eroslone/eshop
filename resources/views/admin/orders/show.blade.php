<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">订单流水号：{{ $order->no }}</h3>
        <div class="box-tools">
            <div class="btn-group float-right" style="margin-right: 10px">
                <a href="{{ url('admin/order') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 列表</a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>买家：</td>
                <td>{{ $order->user->name }}</td>
                <td>支付时间：</td>
                <td colspan="2">{{ $order->paid_at}}</td>
            </tr>
            <tr>
                <td>支付方式：</td>
                <td>{{ $order->payment_method }}</td>
                <td>支付渠道单号：</td>
                <td colspan="2">{{ $order->no }}</td>
            </tr>
            <tr>
                <td>收件人信息</td>
                <td colspan="2">{{ $order->address->recipients }} {{ $order->address->phone }}</td>
                <td>收货地址</td>
                <td colspan="2">{{ $order->address->province_name }} {{ $order->address->city_name }} {{ $order->address->district_name }} {{ $order->address->address }}</td>
            </tr>
            <tr>
                <td rowspan="{{ $order->orderSon->count() + 1 }}">商品列表</td>
                <td>商品名称</td>
                <td>规格</td>
                <td>单价</td>
                <td>数量</td>
            </tr>
            @foreach($order->orderSon as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->attr->differences }}</td>
                    <td>￥{{ $item->price }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @endforeach
            <tr>
                <td>订单金额：</td>
                <td colspan="2">￥{{ $order->price }}</td>
                <td>发货状态：</td>
                <td>{{ $order->state_info }}</td>
            </tr>
            <!-- 订单发货开始 -->
            <!-- 如果订单未发货，展示发货表单 -->
            @if($order->state ==1)
                <tr>
                    <td colspan="5">
                        <form action="{{ route('admin.orders.ship', [$order->id]) }}" method="post" class="form-inline">
                            <!-- 别忘了 csrf token 字段 -->
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('express_company') ? 'has-error' : '' }}">
                                <label for="express_company" class="control-label">物流公司</label>
                                <input type="text" id="express_company" name="express_company" value="" class="form-control" placeholder="输入物流公司">
                                @if($errors->has('express_company'))
                                    @foreach($errors->get('express_company') as $msg)
                                        <span class="help-block">{{ $msg }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('express_no') ? 'has-error' : '' }}">
                                <label for="express_no" class="control-label">物流单号</label>
                                <input type="text" id="express_no" name="express_no" value="" class="form-control" placeholder="输入物流单号">
                                @if($errors->has('express_no'))
                                    @foreach($errors->get('express_no') as $msg)
                                        <span class="help-block">{{ $msg }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success" id="ship-btn">发货</button>
                        </form>
                    </td>
                </tr>
            @else
                <!-- 否则展示物流公司和物流单号 -->
                <tr>
                    <td>物流公司：</td>
                    <td>{{ $order->express_company }}</td>
                    <td>物流单号：</td>
                    <td colspan="2">{{ $order->express_no}}</td>
                </tr>
            @endif
            <!-- 订单发货结束 -->
            @if($order->refund == 1||$order->refund == 2||$order->refund == 3)
                <tr>
                    <td>退款状态：</td>
                    <td colspan="2">{{$order->refund_info}}，理由：{{ $order->refund_reason }}</td>
                    <td>
                        <!-- 如果订单退款状态是已申请，则展示处理按钮 -->
                        @if($order->refund == 1)
                            <button class="btn btn-sm btn-success" id="btn-refund-agree">同意</button>
                            <button class="btn btn-sm btn-danger" id="btn-refund-disagree">不同意</button>
                        @endif
                    </td>
                </tr>
            @endif
            @if($order->refund == 4||$order->refund == 5||$order->refund == 6||$order->refund == 7||$order->refund == 13)

                <tr style="background-color:gray">
                    <td>换货状态：</td>
                    <td colspan="2">{{$order->refund_info}}，理由：{{ $order->refund_reason }}</td>
                    <td colspan="2">
                        <!-- 如果订单退款状态是已申请，则展示处理按钮 -->
                        @if($order->refund == 4)
                            <button class="btn btn-sm btn-success" id="btn-exchangeGoods-agree">同意</button>
                            <button class="btn btn-sm btn-danger" id="btn-exchangeGoods-disagree">不同意</button>
                        @endif
                    </td>
                </tr>
                <tr style="background-color:gray">
                    <td rowspan="{{ $order->orderSon->count() + 1 }}">换货列表</td>
                    <td colspan="2">商品名称</td>
                    <td colspan="2">规格</td>
                </tr>
                @foreach($order->exchange_goods as $item)
                    <tr style="background-color:gray">
                        <td colspan="2">{{ $item->product->name }}</td>
                        <td colspan="2">{{ $item->attr->differences }}</td>
                    </tr>
                @endforeach
                <tr style="background-color:gray">
                    <td>货物状态：</td>
                    <td colspan="2">{{ $order->freight_state}}</td>
                    <td>返回方式：</td>
                    <td colspan="2">{{ $order->return_way}}</td>
                </tr>
                <tr style="background-color:gray">
                    <td>返回单号：</td>
                    <td colspan="2">{{ $order->refund_no}}</td>
                    <td colspan="2">
                        <!-- 如果订单退款状态是已申请，则展示处理按钮 -->
                        @if($order->refund == 6)
                            <button class="btn btn-sm btn-success" id="btn-affirmTake-agree" >确认收货</button>
                        @endif
                    </td>
                </tr>
            @endif
            @if($order->refund == 8||$order->refund == 9||$order->refund == 10||$order->refund == 11||$order->refund == 12)
                <tr style="background-color:gray">
                    <td>退货状态：</td>
                    <td colspan="2">{{$order->refund_info}}，理由：{{ $order->refund_reason }}</td>
                    <td colspan="2">
                        <!-- 如果订单退款状态是已申请，则展示处理按钮 -->
                        @if($order->refund == 8)
                            <button class="btn btn-sm btn-success" id="btn-refundGoods-agree">同意</button>
                            <button class="btn btn-sm btn-danger" id="btn-refundGoods-disagree">不同意</button>
                        @endif
                    </td>
                </tr>
                <tr style="background-color:gray">
                    <td>返回单号：</td>
                    <td colspan="2">{{ $order->refund_no}}</td>
                    <td colspan="2">
                        <!-- 如果订单退款状态是已申请，则展示处理按钮 -->
                        @if($order->refund == 10)
                            <button class="btn btn-sm btn-success" id="btn-affirmRefundTake-agree">确认收货</button>
                        @endif
                    </td>
                </tr>
            @endif
            </tbody>
        </table>

    </div>
</div>
<script>
    $(document).ready(function() {
        // 同意 按钮的点击事件
        $('#btn-refund-agree').click(function() {
            swal({
                title: '确认要将款项退还给用户？',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return $.ajax({
                        url: '{{ url('orders.handle_refund', [$order->id]) }}',
                        type: 'POST',
                        data: JSON.stringify({
                            agree: true, // 代表同意退款
                            _token: LA.token,
                        }),
                        contentType: 'application/json',
                    });
                },
                allowOutsideClick: false
            }).then(function (ret) {
                // 如果用户点击了『取消』按钮，则不做任何操作
                if (ret.dismiss === 'cancel') {
                    return;
                }
                swal({
                    title: '操作成功',
                    type: 'success'
                }).then(function() {
                    // 用户点击 swal 上的按钮时刷新页面
                    location.reload();
                });
            });
        });
        // 不同意 按钮的点击事件
        $('#btn-refund-disagree').click(function() {
            // Laravel-Admin 使用的 SweetAlert 版本与我们在前台使用的版本不一样，因此参数也不太一样
            swal({
                title: '输入拒绝退款理由',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                showLoaderOnConfirm: true,
                preConfirm: function(inputValue) {
                    if (!inputValue) {
                        swal('理由不能为空', '', 'error')
                        return false;
                    }
                    // Laravel-Admin 没有 axios，使用 jQuery 的 ajax 方法来请求
                    return $.ajax({
                        url: '{{ url('admin.orders.handle_refund', [$order->id]) }}',
                        type: 'POST',
                        data: JSON.stringify({   // 将请求变成 JSON 字符串
                            agree: false,  // 拒绝申请
                            reason: inputValue,
                            // 带上 CSRF Token
                            // Laravel-Admin 页面里可以通过 LA.token 获得 CSRF Token
                            _token: LA.token,
                        }),
                        contentType: 'application/json',  // 请求的数据格式为 JSON
                    });
                },
                allowOutsideClick: false
            }).then(function (ret) {
                // 如果用户点击了『取消』按钮，则不做任何操作
                if (ret.dismiss === 'cancel') {
                    return;
                }
                swal({
                    title: '操作成功',
                    type: 'success'
                }).then(function() {
                    // 用户点击 swal 上的按钮时刷新页面
                    location.reload();
                });
            });
        });
        // 同意换货 按钮的点击事件
        $('#btn-exchangeGoods-agree').click(function() {
            swal({
                title: '确认同意换货？',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return $.ajax({
                        url: '{{ url('admin.orders.exchangeGoods', [$order->id]) }}',
                        type: 'POST',
                        data: JSON.stringify({
                            agree: true, // 代表同意退款
                            _token: LA.token,
                        }),
                        contentType: 'application/json',
                    });
                },
                allowOutsideClick: false
            }).then(function (ret) {
                // 如果用户点击了『取消』按钮，则不做任何操作
                if (ret.dismiss === 'cancel') {
                    return;
                }
                swal({
                    title: '操作成功',
                    type: 'success'
                }).then(function() {
                    // 用户点击 swal 上的按钮时刷新页面
                    location.reload();
                });
            });
        });
        // 不同意换货 按钮的点击事件
        $('#btn-exchangeGoods-disagree').click(function() {
            // Laravel-Admin 使用的 SweetAlert 版本与我们在前台使用的版本不一样，因此参数也不太一样
            swal({
                title: '输入拒绝换货理由',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                showLoaderOnConfirm: true,
                preConfirm: function(inputValue) {
                    if (!inputValue) {
                        swal('理由不能为空', '', 'error')
                        return false;
                    }
                    // Laravel-Admin 没有 axios，使用 jQuery 的 ajax 方法来请求
                    return $.ajax({
                        url: '{{ url('admin.orders.exchangeGoods', [$order->id]) }}',
                        type: 'POST',
                        data: JSON.stringify({   // 将请求变成 JSON 字符串
                            agree: false,  // 拒绝申请
                            reason: inputValue,
                            // 带上 CSRF Token
                            // Laravel-Admin 页面里可以通过 LA.token 获得 CSRF Token
                            _token: LA.token,
                        }),
                        contentType: 'application/json',  // 请求的数据格式为 JSON
                    });
                },
                allowOutsideClick: false
            }).then(function (ret) {
                // 如果用户点击了『取消』按钮，则不做任何操作
                if (ret.dismiss === 'cancel') {
                    return;
                }
                swal({
                    title: '操作成功',
                    type: 'success'
                }).then(function() {
                    // 用户点击 swal 上的按钮时刷新页面
                    location.reload();
                });
            });
        });
        //确认货物返回（换货）
        $('#btn-affirmTake-agree').click(function() {
            swal({
                title: '确认接受货物？',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return $.ajax({
                        url: '{{ url('admin.orders.affirmTake', [$order->id]) }}',
                        type: 'POST',
                        data: JSON.stringify({
                            agree: true, // 代表同意退款
                            _token: LA.token,
                        }),
                        contentType: 'application/json',
                    });
                },
                allowOutsideClick: false
            }).then(function (ret) {
                // 如果用户点击了『取消』按钮，则不做任何操作
                if (ret.dismiss === 'cancel') {
                    return;
                }
                swal({
                    title: '操作成功',
                    type: 'success'
                }).then(function() {
                    // 用户点击 swal 上的按钮时刷新页面
                    location.reload();
                });
            });
        });
        // 同意退货 按钮的点击事件
        $('#btn-refundGoods-agree').click(function() {
            swal({
                title: '确认同意退货？',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return $.ajax({
                        url: '{{ url('admin.orders.refundGoods', [$order->id]) }}',
                        type: 'POST',
                        data: JSON.stringify({
                            agree: true, // 代表同意退款
                            _token: LA.token,
                        }),
                        contentType: 'application/json',
                    });
                },
                allowOutsideClick: false
            }).then(function (ret) {
                // 如果用户点击了『取消』按钮，则不做任何操作
                if (ret.dismiss === 'cancel') {
                    return;
                }
                swal({
                    title: '操作成功',
                    type: 'success'
                }).then(function() {
                    // 用户点击 swal 上的按钮时刷新页面
                    location.reload();
                });
            });
        });
        // 不同意退货 按钮的点击事件
        $('#btn-refundGoods-disagree').click(function() {
            // Laravel-Admin 使用的 SweetAlert 版本与我们在前台使用的版本不一样，因此参数也不太一样
            swal({
                title: '输入拒绝退货理由',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                showLoaderOnConfirm: true,
                preConfirm: function(inputValue) {
                    if (!inputValue) {
                        swal('理由不能为空', '', 'error')
                        return false;
                    }
                    // Laravel-Admin 没有 axios，使用 jQuery 的 ajax 方法来请求
                    return $.ajax({
                        url: '{{ url('admin.orders.refundGoods', [$order->id]) }}',
                        type: 'POST',
                        data: JSON.stringify({   // 将请求变成 JSON 字符串
                            agree: false,  // 拒绝申请
                            reason: inputValue,
                            // 带上 CSRF Token
                            // Laravel-Admin 页面里可以通过 LA.token 获得 CSRF Token
                            _token: LA.token,
                        }),
                        contentType: 'application/json',  // 请求的数据格式为 JSON
                    });
                },
                allowOutsideClick: false
            }).then(function (ret) {
                // 如果用户点击了『取消』按钮，则不做任何操作
                if (ret.dismiss === 'cancel') {
                    return;
                }
                swal({
                    title: '操作成功',
                    type: 'success'
                }).then(function() {
                    // 用户点击 swal 上的按钮时刷新页面
                    location.reload();
                });
            });
        });
        //确认货物返回（退货）
        $('#btn-affirmRefundTake-agree').click(function() {
            swal({
                title: '确认接受货物？',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return $.ajax({
                        url: '{{ url('admin.orders.affirmRefundTake', [$order->id]) }}',
                        type: 'POST',
                        data: JSON.stringify({
                            agree: true, // 代表同意退款
                            _token: LA.token,
                        }),
                        contentType: 'application/json',
                    });
                },
                allowOutsideClick: false
            }).then(function (ret) {
                // 如果用户点击了『取消』按钮，则不做任何操作
                if (ret.dismiss === 'cancel') {
                    return;
                }
                swal({
                    title: '操作成功',
                    type: 'success'
                }).then(function() {
                    // 用户点击 swal 上的按钮时刷新页面
                    location.reload();
                });
            });
        });
    });
</script>
