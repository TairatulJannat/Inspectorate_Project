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
                                <input type="hidden" name="indentRefNo" value="{{ $indentRefNo }}">
                                <div class="tender-id f-20">Tender Ref. No: <span class="fw-bold">{{ $tenderRefNo }}</span>
                                </div>
                                <input type="hidden" name="tender-id" value="{{ $tenderId }}">
                                <div class="offerRefNo f-20">Offer Ref. No: <span
                                        class="fw-bold">{{ $offerRefNo }}</span>
                                </div>
                                <input type="hidden" name="offerRefNo" value="{{ $offerRefNo }}">
                                <div class="supplier-id f-20">Supplier Name: <span
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
                            @php
                                $slNo = 0;
                                $groupIndex = 0;
                            @endphp
                            @foreach ($parameterGroups as $groupName => $parameters)
                                <tbody>
                                    <tr>
                                        <td style="background-color: #bdf5fb"></td>
                                        <td colspan="5" style="background-color: #c3d0ff;">
                                            <input type="text" class="form-control bg-body text-body"
                                                name="editedData[{{ $groupIndex }}][parameter_group_name]"
                                                value="{{ $groupName }}" readonly>
                                        </td>
                                    </tr>
                                    @foreach ($parameters as $paramIndex => $parameter)
                                        <tr>
                                            <td class="col-md-1 py-1 text-center" style="background-color: #bdf5fb">
                                                {{ $slNo + 1 }}</td>
                                            <td class="col-md-2 py-1" style="background-color: #bdf5fb">
                                                <textarea class="form-control" name="editedData[{{ $groupIndex }}][{{ $paramIndex }}][parameter_name]">{{ $parameter['parameter_name'] }}</textarea>
                                            </td>
                                            <td class="col-md-3 py-1" style="background-color: #bdf5fb">
                                                <textarea class="form-control" name="editedData[{{ $groupIndex }}][{{ $paramIndex }}][indent_parameter_value]">{{ $parameter['indent_parameter_value'] }}</textarea>
                                            </td>
                                            <td class="col-md-3 py-1" style="background-color: #b0e0bc">
                                                <textarea class="form-control" name="editedData[{{ $groupIndex }}][{{ $paramIndex }}][parameter_value]">{{ $parameter['parameter_value'] }}</textarea>
                                            </td>
                                            <td class="col-md-1 py-1" style="background-color: #b0e0bc">
                                                <select class="form-control select2"
                                                    name="editedData[{{ $groupIndex }}][{{ $paramIndex }}][compliance_status]">
                                                    <option value="Comply" selected>Comply</option>
                                                    <option value="Partially Comply">Partially Comply</option>
                                                    <option value="Non Comply">Non Comply</option>
                                                </select>
                                            </td>
                                            <td class="col-md-2 py-1" style="background-color: #b0e0bc">
                                                <textarea class="form-control" name="editedData[{{ $groupIndex }}][{{ $paramIndex }}][remarks]"></textarea>
                                            </td>
                                        </tr>
                                        @php $slNo++; @endphp
                                    @endforeach
                                </tbody>
                                @php $groupIndex++; @endphp
                            @endforeach
                        </table>
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
    <script>
        window.onload = function() {
            var textareas = document.querySelectorAll('.form-control[name^="editedData"]');

            textareas.forEach(function(textarea) {
                if (textarea.value === "No data found against this parameter!") {
                    var td = textarea.closest('td');

                    td.classList.add('bg-danger');
                    textarea.value = '';
                }
            });
        };
    </script>
@endpush
