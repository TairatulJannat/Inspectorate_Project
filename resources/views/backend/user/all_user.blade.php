@extends('backend.app')
@section('title','All Users')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endpush
@section('main_menu','HOME')
@section('active_menu','All Users')
@section('link',route('admin.dynamic_route'))
@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Total: <span class="badge badge-secondary">{{$users->count()}}</span></h3>
            @if($page_data['add_menu'] == "yes")
                <a class="btn btn-primary" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#add_button">Add
                    User</a>
            @endif
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Support_asst</th>
                    <th>Assigned Role</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $key=>$data)
                    @if($data->id == 92)
                    @else
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->mobile}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->support_asst}}</td>
                        <td>{{($data->role)?$data->role->name:""}}</td>
                        <td>
                            <a href="#" onclick="edit_user({{$data->id}})" class="btn btn-success btn-sm">Edit</a>
                            @if($data->type == 'admin')
                                <a href="#" onclick="suspend_user({{$data->id}})" class="btn btn-danger btn-sm">Suspend</a>
                            @elseif($data->type == 'user')
                                <a href="#" onclick="unsuspend_user({{$data->id}})" class="btn btn-primary btn-sm">UnSuspend</a>
                            @endif
                            <a href="{{route('admin.delete_user',$data->id)}}" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Support_asst</th>
                    <th>Assigned Role</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @if($page_data['modal'] == "yes")
        @include('backend.user.add_user_modal')
        @include('backend.user.edit_user_modal')
    @endif

@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // edit user
        function edit_user(id) {
            event.preventDefault();
            $.ajax({
                url: "{{url('admin/edit_user')}}/" + id,
                type: "GET",
                data: {},
                success: function (response) {
                    if (response) {
                        if (response.permission == false) {
                            toastr.error('you dont have that Permission', 'Permission Denied');
                        } else {
                            $('#edit_body').html('')
                            $('#edit_body').append(response)
                            $('#edit_user').modal('show');
                        }
                    }
                },
            });
        }

        // suspend User
        function suspend_user(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Suspend This User!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    window.location.href = '{{url('admin/suspend_user')}}/' + id;
                } else if (
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

        // suspend User
        function unsuspend_user(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, UnSuspend This User!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    window.location.href = '{{url('admin/unsuspend_user')}}/' + id;
                } else if (
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
