@extends("layouts.common")
@section('page-content-wrapper')
    <div class="table-rep-plugin">
        <div class="btn-toolbar">
            <div class="button-items btn-group"></div>
            <div class="search-bar btn-group pull-right"></div>
        </div>
        <div class="table-responsive mb-0" data-pattern="priority-columns">
            <table id="currentTable" class="table table-striped">
            </table>
        </div>
    </div>
@endsection
@section('extend-javascript')
    <script>
        myAdmin.table({
            table_elem: '#currentTable',
            index_url: '/admin/addon/upgrade',
        }, [
            {field: 'id', minWidth: 80, title: '序号'},
            {field: 'before_version', minWidth: 80, title: '更新前'},
            {field: 'after_version', minWidth: 80, title: '更新后'},
            {field: 'created_at', minWidth: 120, title: '时间'},
        ], [{
            text: '检测版本更新',
            class: 'btn btn-primary waves-effect waves-light',
            url: '/admin/addon/upgrade/version'
        }]);
    </script>
@endsection
