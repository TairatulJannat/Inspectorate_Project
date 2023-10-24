@extends('backend.app')
@section('title','Add role')
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{asset('assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endpush
@section('main_menu','HOME')
@section('active_menu','Add role')
@section('link',route('admin.dynamic_route'))
@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Total Role: <span class="badge badge-secondary">{{$role->count()}}</span></h3>
            @if($page_data['add_menu'] == "yes")
                <a href="{{route('admin.role/add_role')}}" type="button" class="btn-sm btn-success float-right">Add role</a>
            @endif
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>slag</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($role as $key=>$data)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->slag}}</td>
                        <td>
                            <a href="{{route('admin.edit_role',$data->id)}}" class="btn btn-success btn-sm">Edit</a>
                           {{-- <a href="#" onclick="deletePost({{$data->id}})" class="btn btn-danger btn-sm">Delete</a> --}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>slag</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->






    @if($page_data['modal'] == "yes")

        <div class="modal fade" id="add_button" tabindex="-1" role="dialog" aria-labelledby="add_buttonLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add_buttonLabel">Route Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="Route_name">Route name</label>
                                <input type="text" class="form-control" id="Route name" aria-describedby="emailHelp"
                                       placeholder="Enter Route name" name="route_name">
                            </div>

                            <div class="form-group">
                                <label for="controller_action">Controller Action</label>
                                <input type="text" class="form-control" id="controller_action"
                                       aria-describedby="emailHelp" placeholder="Enter Controller Action">
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Diactive</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="route_type">Route Type</label>
                                <select class="form-control" id="route_type" name="route_type">
                                    <option value="1">Main Route</option>
                                    <option value="0">Public Route</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@push('js')
    <!-- DataTables -->
    <script src="{{asset('assets/backend/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
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
                    window.location.href = "{{url('admin/delete_role')}}/" + id;
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
