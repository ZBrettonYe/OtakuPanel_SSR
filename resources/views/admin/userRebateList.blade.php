@extends('admin.layouts')
@section('css')
    <link href="/assets/global/vendor/bootstrap-table/bootstrap-table.min.css" type="text/css" rel="stylesheet">
@endsection
@section('content')
    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-heading">
                <h2 class="panel-title">返利流水记录</h2>
            </div>
            <div class="panel-body">
				<div class="form-row">
					<div class="form-group col-lg-4 col-sm-6">
                        <input type="text" class="form-control" name="username" id="username" value="{{Request::get('username')}}" placeholder="消费者"/>
                    </div>
					<div class="form-group col-lg-4 col-sm-6">
                        <input type="text" class="form-control" name="ref_username" id="ref_username" value="{{Request::get('ref_username')}}" placeholder="邀请人"/>
                    </div>
					<div class="form-group col-lg-2 col-sm-6">
                        <select name="status" id="status" class="form-control" onChange="Search()">
                            <option value="" @if(Request::get('status') == '') selected hidden @endif>状态</option>
                            <option value="0" @if(Request::get('status') == '0') selected hidden @endif>未提现</option>
                            <option value="1" @if(Request::get('status') == '1') selected hidden @endif>申请中</option>
                            <option value="2" @if(Request::get('status') == '2') selected hidden @endif>已提现</option>
                        </select>
                    </div>
					<div class="form-group col-lg-2 col-sm-6 btn-group">
                        <button class="btn btn-primary" onclick="Search()">搜索</button>
                        <a href="/admin/userRebateList" class="btn btn-danger">重置</a>
                    </div>
                </div>
                <table class="text-md-center" data-toggle="table" data-mobile-responsive="true">
                    <thead class="thead-default">
                    <tr>
                        <th> #</th>
                        <th> 消费者</th>
                        <th> 邀请者</th>
                        <th> 订单号</th>
                        <th> 消费金额</th>
                        <th> 返利金额</th>
                        <th> 生成时间</th>
                        <th> 处理时间</th>
                        <th> 状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($list->isEmpty())
                        <tr>
                            <td colspan="9">暂无数据</td>
                        </tr>
                    @else
                        @foreach($list as $vo)
                            <tr>
                                <td> {{$vo->id}} </td>
                                <td>
                                    @if(empty($vo->user))
                                        【账号已删除】
                                    @else
                                        <a href="/admin/userRebateList?username={{$vo->user->username}}"> {{$vo->user->username}} </a>
                                    @endif
                                </td>
                                <td>
                                    @if(empty($vo->ref_user))
                                        【账号已删除】
                                    @else
                                        <a href="/admin/userRebateList?ref_username={{$vo->ref_user->username}}"> {{$vo->ref_user->username}} </a>
                                    @endif
                                </td>
                                <td> {{$vo->order_id}} </td>
                                <td> {{$vo->amount}} </td>
                                <td> {{$vo->ref_amount}} </td>
                                <td> {{$vo->created_at}} </td>
                                <td> {{$vo->updated_at}} </td>
                                <td>
                                    @if ($vo->status == 1)
                                        <span class="badge badge-danger">申请中</span>
                                    @elseif($vo->status == 2)
                                        <span class="badge badge-default">已提现</span>
                                    @else
                                        <span class="badge badge-info">未提现</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-4">
                        共 <code>{{$list->total()}}</code> 个申请
                    </div>
                    <div class="col-sm-8">
                        <nav class="Page navigation float-right">
                            {{$list->links()}}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="/assets/global/vendor/bootstrap-table/bootstrap-table.min.js" type="text/javascript"></script>
    <script src="/assets/global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        //回车检测
        $(document).on("keypress", "input", function (e) {
            if (e.which === 13) {
                Search()
            }
        });

        // 搜索
        function Search() {
            const username = $("#username").val();
            const ref_username = $("#ref_username").val();
            const status = $("#status option:selected").val();
            window.location.href = '/admin/userRebateList' + '?username=' + username + '&ref_username=' + ref_username + '&status=' + status;
        }
    </script>
@endsection
