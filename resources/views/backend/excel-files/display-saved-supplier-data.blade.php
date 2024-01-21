@extends('backend.app')

@section('title', 'Edit Imported Data')

@section('main_menu', 'Excel Files')
@section('active_menu', 'Edit Imported Data')

@push('css')
    <style>
        .ck-editor__editable_inline {
            color: black;
            min-height: 200px;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-body" style="background-color: honeydew !important;">

            @if ($offerRefNo)
                <form method="post" action="{{ url('admin/save-remarks-for-supplier') }}" id="editSupplierExcelInput">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-12 d-flex justify-content-center align-items-center">
                            <div class="text-center">
                                <div class="item-id f-30">{{ $itemName }}</div>
                                <input type="hidden" name="item-id" value="{{ $itemId }}">
                                <div class="indent-id f-20">Indent Ref. No: <span class="fw-bold">{{ $indentRefNo }}</span>
                                </div>
                                <input type="hidden" name="indent-id" value="{{ $indentId }}">
                                <div class="tender-id f-20">Tender Ref. No: <span class="fw-bold">{{ $tenderRefNo }}</span>
                                </div>
                                <input type="hidden" name="tender-id" value="{{ $tenderId }}">
                                <div class="offerRefNo f-20">Offer Ref. No: <span class="fw-bold">{{ $offerRefNo }}</span>
                                </div>
                                <input type="hidden" name="offerRefNo" value="{{ $offerRefNo }}">
                                <div class="supplier-id f-20">Supplier Name: <span
                                        class="fw-bold">{{ $supplierFirmName }}</span></div>
                                <input type="hidden" name="supplier-id" value="{{ $supplierId }}">
                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-md-12 bg-warning">
                            <p class="bg-warning px-1 pt-1 mb-0 f-20 fw-bold">Offer Summary:</p>
                            <textarea class="form-control offer_summary" name="offer_summary" id="offer_summary" style="color: black !important"></textarea>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-md-12 bg-warning">
                            <p class="bg-warning px-1 pt-1 mb-0 f-20 fw-bold">Remarks Summary:</p>
                            <textarea class="form-control remarks_summary" name="remarks_summary" id="remarks_summary"
                                style="color: black !important">{{ $mergedRemarks }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 bg-warning">
                            <p class="bg-warning px-1 pt-1 mb-0 f-20 fw-bold">Offer Status:</p>
                            <select class="form-control select2 mb-2" name="offer_status">
                                <option value="Accepted" selected>Accepted</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success-gradien mt-3">Save Changes</button>
                    </div>
                </form>
            @else
                <p>No data imported.</p>
            @endif
        </div>
        <div class="card-footer py-3" style="background-color: teal !important;">
            <a href="{{ url('admin/import-supplier-spec-data-index') }}"
                class="btn btn-danger-gradien float-end">Cancel</a>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/backend/js/ckeditor5/ckeditor.min.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#offer_summary'))
            .then(editor => {
                editor.setData(
                    '<ol><li>Offer No: </li><li>Model: </li><li>Name of Manufacturer: </li><li>Name of Principal: </li><li>Name of Local Agent: </li><li>Country of Origin: </li><li>Country of Manufacture: </li><li>Country of Assembly: </li><li>Port of Shipment: </li></ol>'
                );
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#remarks_summary'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
