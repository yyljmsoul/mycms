@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#base" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">物流信息</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#dynamic" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">物流动态</span>
                </a>
            </li>
        </ul>

        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="base" role="tabpanel">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">快递公司</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="delivery_type" id="delivery_type"
                        >
                            <option value="0">请选择快递公司</option>
                            @foreach($expressList as $alias => $express)
                                <option value="{{$alias}}"
                                        @if($order->delivery_type == $alias) selected @endif>{{$express}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">快递单号</label>
                    <div class="col-sm-10">
                        <input type="text" name="delivery_code" class="form-control"
                               placeholder="请输入快递单号"
                               value="{{$order->delivery_code}}">
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="dynamic" role="tabpanel">

                <table class="layui-table">
                    <tbody>
                    @foreach($logistics as $log)
                        <tr>
                            <td>{{$log['time']}}</td>
                            <td>{{$log['context']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$order->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>
    </form>
@endsection
