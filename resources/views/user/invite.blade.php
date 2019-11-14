@extends('user.layouts')
@section('content')
    <div class="page-header">
        <h1 class="page-title cyan-600"><i class="icon wb-extension"></i>{{trans('home.invite_code')}}</h1>
        <div class="page-content container-fluid">
            <div class="alert alert-info" role="alert">
                <button class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                {!! trans('home.promote_invite_code', ['traffic' => $referral_traffic, 'referral_percent' => $referral_percent * 100]) !!}
            </div>
            <div class="row">
                <div class="col-xxl-3 col-lg-4">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title cyan-600"><i class="icon wb-plus"></i> {{trans('home.invite_code_make')}}
                            </h4>
                            <p class="card-text alert alert-info">
                                <i class="icon wb-warning red-700"></i> {{trans('home.invite_code_tips1')}} <strong> {{$num}} </strong> {{trans('home.invite_code_tips2', ['days' => \App\Components\Helpers::systemConfig()['user_invite_days']])}}
                            </p>
                            <button type="button" class="btn btn-primary btn-animate btn-animate-side" onclick="makeInvite()" @if(!$num)  disabled @endif><i class="icon wb-plus"></i> {{trans('home.invite_code_button')}}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-9 col-lg-8">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title cyan-600"><i class="icon wb-extension"></i>{{trans('home.invite_code_my_codes')}}
                            </h4>
                            <div class="table-responsive">
                                <table class="table text-center" data-mobile-responsive="true">
                                    <thead class="thead-default">
                                    <tr>
                                        <th data-cell-style="cellStyle"> #</th>
                                        <th> {{trans('home.invite_code_table_name')}} </th>
                                        <th> {{trans('home.invite_code_table_date')}} </th>
                                        <th> {{trans('home.invite_code_table_status')}} </th>
                                        <th> {{trans('home.invite_code_table_user')}} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($inviteList->isEmpty())
                                        <tr>
                                            <td colspan="5">{{trans('home.invite_code_table_none_codes')}}</td>
                                        </tr>
                                    @else
                                        @foreach($inviteList as $invite)
                                            <tr>
                                                <td> {{$loop->iteration}} </td>
                                                <td>
                                                    <a href="/register?aff={{Auth::user()->id}}&code={{$invite->code}}" target="_blank">{{$invite->code}}</a>
                                                </td>
                                                <td> {{$invite->dateline}} </td>
                                                <td>
                                                    @if($invite->status == '0')
                                                        <span class="badge badge-success">{{trans('home.invite_code_table_status_un')}}</span>
                                                    @elseif($invite->status == '1')
                                                        <span class="badge badge-danger">{{trans('home.invite_code_table_status_yes')}}</span>
                                                    @else
                                                        <span class="badge badge-default">{{trans('home.invite_code_table_status_expire')}}</span>
                                                    @endif
                                                </td>
                                                @if($invite->status == '1')
                                                    <td> {{empty($invite->user) ? ($invite->status == 1 ? '【账号已删除】' : '') : $invite->user->username}} </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                   {{trans('home.invite_code_summary', ['total' => $inviteList->total()])}}
                                </div>
                                <div class="col-md-8">
                                    <nav class="Page navigation float-right">
                                        {{$inviteList->links()}}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        // 生成邀请码
        function makeInvite() {
            const _token = '{{csrf_token()}}';

            $.ajax({
                type: "POST",
                url: "/makeInvite",
                async: false,
                data: {_token: _token},
                dataType: 'json',
                success: function (ret) {
                    swal.fire({title: ret.message, timer: 1000})
                        .then(() => {
                            if (ret.status === 'success') {
                                window.location.reload();
                            }
                        });
                }
            });
            return false;
        }
    </script>
@endsection
