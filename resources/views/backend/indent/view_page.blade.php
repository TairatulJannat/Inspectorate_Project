@extends('backend.app')
@section('title','Blank')
@push('css')
@endpush
@section('main_menu','Blank')
@section('active_menu','Blank')
{{--@section('link',route('admin.adminDashboard'))--}}
@section('content')


<table class='table'>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Inspectorate</th>
        <th>Details</th>
    </tr>
    @foreach ($indents as $item)
    <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->inspectorate_id}}</td>
        <td>{{$item->details}}</td>
    </tr>
    @endforeach
</table>
    

@endsection
@push('js')
@endpush
