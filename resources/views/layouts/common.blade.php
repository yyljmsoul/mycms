@extends("layouts.base")

@section('container-fluid')

    <div class="container-fluid">
        <div class="page-content-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @yield('page-content-wrapper')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->

@endsection

@section('extend-javascript')
    <script>
        myAdmin.listen();
    </script>
@endsection
