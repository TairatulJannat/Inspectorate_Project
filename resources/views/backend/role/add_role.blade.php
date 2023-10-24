@extends('backend.app')
@section('title','Add Role')
@push('css')
@endpush
@section('main_menu','HOME')
@section('active_menu','Add Role')
@section('link',route('admin.adminDashboard'))
@section('content')



    <div class="row">
        <div class="col-md-12">
            <form action="{{route('admin.save_role')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="Route_name">Role name</label>
                    <input type="text" class="form-control" id="Role name" aria-describedby="emailHelp"
                           placeholder="Enter Route name" name="name">
                </div>
                Permission
                <hr>

                <div class="col-xs-12">
                    <div class="row">
                        @foreach($route as $head=>$data1)
                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item"><span class="text-bold">{{$head}}</span>
                                        @foreach($data1 as $data2)
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               value="{{$data2->id}}"
                                                               id="defaultCheck.{{$data2->id}}" name="route_name[]">
                                                        <label class="form-check-label"
                                                               for="defaultCheck.{{$data2->id}}">
                                                            {{$data2->title}}
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>


                <br>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

    </div>









@endsection
@push('js')
@endpush
