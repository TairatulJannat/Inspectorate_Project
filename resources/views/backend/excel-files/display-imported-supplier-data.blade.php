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
            @if ($parameterGroups)
                <form method="post" action="{{ url('admin/save-supplier-spec-data') }}" id="editSupplierExcelInput">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-12 d-flex justify-content-center align-items-center">
                            <div class="text-center">
                                <div class="item-id f-30">{{ $itemName }}</div>
                                <input type="hidden" name="item-id" value="{{ $itemId }}">
                                <div class="item-type-id f-28">{{ $itemTypeName }}</div>
                                <input type="hidden" name="item-type-id" value="{{ $itemTypeId }}">
                                <div class="indent-id f-20">Indent Ref. No: <span class="fw-bold">{{ $indentRefNo }}</span>
                                </div>
                                <input type="hidden" name="indent-id" value="{{ $indentId }}">
                                <div class="tender-id f-20">Tender Ref. No: <span class="fw-bold">{{ $tenderRefNo }}</span>
                                </div>
                                <input type="hidden" name="tender-id" value="{{ $tenderId }}">
                                <div class="supplier-id f-20">Supplier Firm name: <span
                                        class="fw-bold">{{ $supplierFirmName }}</span></div>
                                <input type="hidden" name="supplier-id" value="{{ $supplierId }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <table class="table table-bordered table-hover mb-3">
                            <thead>
                                <tr>
                                    <th style="background-color: #bdf5fb">Sl No.</th>
                                    <th style="background-color: #bdf5fb">Parameter name</th>
                                    <th style="background-color: #bdf5fb">Indent Parameter value</th>
                                    <th style="background-color: #b0e0bc">Supplier Parameter value</th>
                                    <th style="background-color: #b0e0bc">Compliance Status</th>
                                    <th style="background-color: #b0e0bc">Remarks</th>
                                </tr>
                            </thead>
                            @php $slNo = 0; @endphp
                            @foreach ($parameterGroups as $groupName => $parameters)
                                <tbody>
                                    <tr>
                                        <td style="background-color: #bdf5fb"></td>
                                        <td colspan="5" style="background-color: #c3d0ff;">
                                            <input type="text" class="form-control bg-body text-body"
                                                name="editedData[{{ $groupName }}][parameter_group_name]"
                                                value="{{ $groupName }}" disabled>
                                        </td>
                                    </tr>
                                    @foreach ($parameters as $parameter)
                                        <tr>
                                            <td class="col-md-1 py-1 text-center" style="background-color: #bdf5fb">
                                                {{ $slNo + 1 }}</td>
                                            <td class="col-md-2 py-1" style="background-color: #bdf5fb">
                                                <input type="text" class="form-control"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][parameter_name]"
                                                    value="{{ $parameter['parameter_name'] }}">
                                            </td>
                                            <td class="col-md-3 py-1" style="background-color: #bdf5fb">
                                                <textarea class="form-control"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][indent_parameter_value]">{{ $parameter['indent_parameter_value'] }}</textarea>
                                            </td>
                                            <td class="col-md-2 py-1" style="background-color: #b0e0bc">
                                                <textarea class="form-control"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][parameter_value]">{{ $parameter['parameter_value'] }}</textarea>
                                            </td>
                                            <td class="col-md-2 py-1" style="background-color: #b0e0bc">
                                                <select class="form-control select2"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][compliance_status]">
                                                    <option value="Comply" selected>Comply</option>
                                                    <option value="Partially Comply">Partially Comply</option>
                                                    <option value="Non Comply">Non Comply</option>
                                                </select>
                                            </td>
                                            <td class="col-md-2 py-1" style="background-color: #b0e0bc">
                                                <input type="text" class="form-control"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][remarks]"
                                                    value="">
                                            </td>
                                        </tr>
                                        @php $slNo++; @endphp
                                    @endforeach
                                </tbody>
                            @endforeach
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6 bg-warning">
                            <p class="bg-warning px-1 pt-1 mb-0">Offer Summary:</p>
                            <textarea class="form-control offer_summary" name="offer_summary" id="offer_summary" style="color: black !important"></textarea>
                        </div>
                        <div class="col-md-6 bg-warning">
                            <p class="bg-warning px-1 pt-1 mb-0">Remarks Summary:</p>
                            <textarea class="form-control remarks_summary" name="remarks_summary" id="remarks_summary"
                                style="color: black !important"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 bg-warning">
                            <p class="bg-warning px-1 pt-1 mb-0">Offer Status:</p>
                            <select class="form-control select2 mb-2" name="offer_status">
                                <option value="Accepted" selected>Accepted</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-success-gradien mt-3 float-end">Save Changes</button>
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor5/40.2.0/ckeditor.min.js"
        integrity="sha512-8gumiqgUuskL3/m+CdsrNnS9yMdMTCdo5jj5490wWG5QaxStAxJSYNJ0PRmuMNYYtChxYVFQuJD0vVQwK2Y1bQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#offer_summary'))
            .then(editor => {
                editor.setData(
                    '<ol><li>Offer No: </li><li>Model: </li><li>Name of Manufacturer: </li><li>Name of Principal: </li><li>Name of Local Agent: </li><li>Country of Origin: Sweden</li><li>Country of Manufacture: Sweden</li><li>Country of Assembly: Sweden</li><li>Port of Shipment: Sweden</li></ol>'
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
