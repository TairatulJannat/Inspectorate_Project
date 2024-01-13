@extends('backend.app')

@section('title', 'Imported Data')

@section('main_menu', 'Excel Files')
@section('active_menu', 'Imported Data')

@push('css')
    <style>
        .ck-editor__editable_inline {
            color: black;
            min-height: 200px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid dashboard-default-sec">



        <div class="card" style="background-color: #2c7f70;">
            <form id="import-indent-spec-data-form" method="POST" action="" accept-charset="utf-8"
                enctype="multipart/form-data">
               @csrf
              <div class="d-flex justify-content-center p-5">
                <div  class=" text-center text-light">
                    <h4>Draft Contact Reference No: {{$draftContract->reference_no}}</h4>
                    <h4>Indent Reference No: {{$draftContract->indent_reference_no}}</h4>
                    <h4>Offer Reference No: {{$draftContract->offer_reference_no}}</h4>
                    <h4>Item Type: {{$itemType->name}}</h4>
                    <h4>Item Name: {{$item->name}}</h4>
                </div>

              </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="file" class="form-label mb-2 text-white f-22">Choose Excel/CSV
                                    File:</label>
                                <input class="form-control" type="file" id="file" name="file">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary float-end">Import</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/ckeditor5/ckeditor.min.js') }}"></script>
@endpush
