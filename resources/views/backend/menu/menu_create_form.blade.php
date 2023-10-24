@extends('backend.app')
@section('title','Create Menu')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
@endpush
@section('main_menu','HOME')
@section('active_menu','Create Menu')
@section('link',route('admin.dynamic_route'))
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>Create Menu</h3></div>
                <div class="card-body">
                    <form class="forms-sample" method="post" action="{{route('admin.menu/menu_save')}}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Menu Name</label>
                            <input type="text" class="form-control" placeholder="Menu name" name="menu_name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Menu Bangla Name</label>
                            <input type="text" class="form-control" placeholder="Bangla Name" name="menu_bangla_name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Icon Class</label>
                            <input type="text" class="form-control" placeholder="Icon Class" name="icon_class">
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="">Activation Status</label>
                                <select class="form-control select2" name="active_status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label for="">Select Parent Menu</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="" >No Parent</option>
                                    @foreach($master_menu as $data)
                                        <option value="{{$data->id}}">{{$data->menu_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label for="">Select Route</label>
                                <select class="form-control select2" name="route_id">
                                    <option value="" >No Route</option>
                                    @foreach($route as $data)
                                        <option value="{{$data->id}}">{{$data->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Create Menu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endpush
