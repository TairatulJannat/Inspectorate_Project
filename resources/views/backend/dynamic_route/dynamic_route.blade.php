@extends('backend.app')
@section('title','Route List')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endpush
@section('main_menu','HOME')
@section('active_menu','Route List')
@section('link',route('admin.dynamic_route'))
@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Total Route: <span class="badge badge-secondary">{{$route->count()}}</span></h3>
            @if($page_data['add_menu'] == "yes")
                <a href="#add_button" data-bs-toggle="modal" type="button" class="btn-sm btn-success" style="margin-left: 85%">Add Route</a>
            @endif
        </div>
        <div class="card-body">
            <table id="datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Route Name</th>
                    <th>Model Name</th>
                    <th>Route Url</th>
                    <th>Route Action</th>
                    <th>Route Method</th>
                    <th>Route Type</th>
                    <th>Route parameter</th>
                    <th>Route status</th>
                    <th>Show in Menu</th>
                    <th>Ajax Route</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($route as $key=>$data)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$data->title}}</td>
                        <td>{{$data->model_name}}</td>
                        <td>{{$data->url}}</td>
                        <td>{{$data->controller_action}}</td>
                        <td>{{$data->method}}</td>

                        <td>
                            @if($data->route_type == 1)
                                main
                            @else
                                Public
                            @endif
                        </td>

                        <td>{{$data->parameter}}</td>
                        <td>
                            @if($data->route_status == 1)
                                <span class="right badge badge-success">Active</span>
                            @else
                                <span class="right badge badge-warning">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if($data->show_in_menu == 1)
                                <span class="right badge badge-info">Yes</span>
                            @else
                                <span class="right badge badge-danger">No</span>
                            @endif
                        </td>
                        <td>
                            @if($data->ajax == 1)
                                <span class="right badge badge-info">Yes</span>
                            @else
                                <span class="right badge badge-danger">No</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.edit_route',$data->id)}}" class="btn btn-sm btn-success">Edit</a>
                            <a href="#" onclick="deletePost({{$data->id}})" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Route Name</th>
                    <th>Model Name</th>
                    <th>Route Url</th>
                    <th>Route Action</th>
                    <th>Route Method</th>
                    <th>Route Type</th>
                    <th>Route parameter</th>
                    <th>Route status</th>
                    <th>Show in Menu</th>
                    <th>Ajax Route</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



    @if($page_data['modal'] == "yes")
        @include('backend.dynamic_route.add_route_model')
    @endif

@endsection
@push('js')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
    <script type="text/javascript">
        function deletePost(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    window.location.href = "{{url('admin/delete_route')}}/" + id;
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>

@endpush
