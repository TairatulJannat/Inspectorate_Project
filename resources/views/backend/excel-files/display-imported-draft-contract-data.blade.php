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
                <form method="post" action="{{ url('admin/save-draft-contract-spec-data') }}"
                    id="editDraftContractExcelInput">
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
                                <input type="hidden" name="indentRefNo" value="{{ $indentRefNo }}">
                                <div class="tender-id f-20">Tender Ref. No: <span class="fw-bold">{{ $tenderRefNo }}</span>
                                </div>
                                <input type="hidden" name="tenderRefNo" value="{{ $tenderRefNo }}">
                                <div class="offerRefNo f-20">Offer Ref. No: <span class="fw-bold">{{ $offerRefNo }}</span>
                                </div>
                                <input type="hidden" name="offerRefNo" value="{{ $offerRefNo }}">
                                <div class="finalSpecRefNo f-20">Final Spec Ref. No: <span
                                        class="fw-bold">{{ $finalSpecRefNo }}</span>
                                </div>
                                <input type="hidden" name="finalSpecRefNo" value="{{ $finalSpecRefNo }}">
                                <div class="dcRefNo f-20">Draft Contract Ref. No: <span
                                        class="fw-bold">{{ $dcRefNo }}</span>
                                </div>
                                <input type="hidden" name="dcRefNo" value="{{ $dcRefNo }}">
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
                                    <th style="background-color: #b0e0bc">Final Spec value</th>
                                    <th style="background-color: #b0e0bc">Draft Contract Spec value</th>
                                    <th style="background-color: #b0e0bc">Remarks</th>
                                </tr>
                            </thead>
                            @php $slNo = 0; @endphp
                            @foreach ($parameterGroups as $groupName => $parameters)
                                <tbody>
                                    <tr>
                                        <td style="background-color: #bdf5fb"></td>
                                        <td colspan="4" style="background-color: #c3d0ff;">
                                            <input type="text" class="form-control bg-body text-body"
                                                name="editedData[{{ $groupName }}][parameter_group_name]"
                                                value="{{ $groupName }}" disabled>
                                        </td>
                                    </tr>
                                    @foreach ($parameters as $parameter)
                                        <tr>
                                            <td class="col-md-1 py-1 text-center" style="background-color: #bdf5fb">
                                                {{ $slNo + 1 }}</td>
                                            <td class="col-md-3 py-1" style="background-color: #bdf5fb">
                                                <textarea class="form-control"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][parameter_name]">{{ $parameter['parameter_name'] }}</textarea>
                                            </td>
                                            <td class="col-md-2 py-1" style="background-color: #b0e0bc">
                                                <textarea class="form-control supplier-parameter-value" id="supplier-{{ $parameter['parameter_name'] }}"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][supplier_parameter_value]">{{ $parameter['supplier_parameter_value'] }}</textarea>
                                            </td>
                                            <td class="col-md-2 py-1" style="background-color: #b0e0bc">
                                                <textarea class="form-control draft-contract-parameter-value" id="draft-contract-{{ $parameter['parameter_name'] }}"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][draft_contract_parameter_value]">{{ $parameter['draft_contract_parameter_value'] }}</textarea>
                                            </td>
                                            <td class="col-md-2 py-1" style="background-color: #b0e0bc">
                                                <textarea class="form-control" name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][remarks]"></textarea>
                                            </td>
                                        </tr>
                                        @php $slNo++; @endphp
                                    @endforeach
                                </tbody>
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
            <a href="{{ url('admin/draft_contract/view') }}" class="btn btn-danger-gradien float-end">Cancel</a>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        window.onload = function() {
            var supplierValueElements = document.querySelectorAll('.supplier-parameter-value');
            var draftContractValueElements = document.querySelectorAll('.draft-contract-parameter-value');

            supplierValueElements.forEach(function(supplierValueElement, index) {
                var draftContractValueElement = draftContractValueElements[index];
                var tdElement = draftContractValueElement.closest('td');

                if (supplierValueElement.value !== draftContractValueElement.value) {
                    tdElement.classList.add('bg-danger');
                }
            });
        };
    </script>
@endpush
