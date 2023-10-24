@extends('backend.app')
@section('title','Edit Route')
@push('css')
@endpush
@section('main_menu','HOME')
@section('active_menu','Edit Route')
@section('link',route('admin.adminDashboard'))
@section('content')



    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>Edit Route</h3></div>
                <div class="card-body">
                    <form action="{{route('admin.update_route',$route->id)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="Route_name">Route name</label>
                            <input type="text" class="form-control" id="Route name" value="{{$route->title}}" name="title">
                        </div>

                        <div class="form-group">
                            <label for="Route_name">Model name</label>
                            <input type="text" class="form-control" id="Route name" value="{{$route->model_name}}"
                                   name="model_name">
                        </div>

                        <div class="form-group">
                            <label for="Route_name">Route Url</label>
                            <input type="text" class="form-control" id="Route name" value="{{$route->url}}" name="url">
                        </div>

                        <div class="form-group">
                            <label for="controller_action">Controller Action</label>
                            <input type="text" class="form-control" id="controller_action"
                                   value="{{$route->controller_action}}"
                                   name="controller_action">
                        </div>

                        <div class="form-group">
                            <label for="controller_action">Funaction Name</label>
                            <input type="text" class="form-control" id="function_name"
                                   value="{{$route->function_name}}"
                                   name="function_name">
                        </div>

                        <div class="form-group">
                            <label for="controller_action">parameter</label>
                            <input type="text" class="form-control" id="controller_action"
                                   value="{{$route->parameter}}" name="parameter">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="route_status">
                                <option value="1" {{ ($route->route_status == 1) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ ($route->route_status == 0) ? 'selected' : '' }}>Diactive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Method</label>
                            <select class="form-control" id="status" name="method">
                                <option value="get" {{ ($route->method == "get") ? 'selected' : '' }}>get</option>
                                <option value="Post" {{ ($route->method == "Post") ? 'selected' : '' }}>post</option>
                            </select>
                        </div>

                        {{--                @php(dd($route->route_status))--}}
                        <div class="form-group">
                            <label for="route_type">Route Type</label>
                            <select class="form-control" id="route_type" name="route_type">
                                <option value="1" {{ ($route->route_type == 1) ? 'selected' : ''  }}>Main Route</option>
                                <option value="0" {{ ($route->route_type == 0) ? 'selected' : ''  }}>Public Route</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="route_type">Show in Menu</label>
                            <select class="form-control" id="show_in_menu" name="show_in_menu">
                                <option value="1" {{ ($route->show_in_menu == 1) ? 'selected' : ''  }}>Yes</option>
                                <option value="0" {{ ($route->show_in_menu == 0) ? 'selected' : ''  }}>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="route_type">Ajax Route</label>
                            <select class="form-control" id="ajax" name="ajax">
                                <option value="1" {{ ($route->ajax == 1) ? 'selected' : ''  }}>Yes</option>
                                <option value="0" {{ ($route->ajax == 0) ? 'selected' : ''  }}>No</option>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>










@endsection
@push('js')
@endpush
