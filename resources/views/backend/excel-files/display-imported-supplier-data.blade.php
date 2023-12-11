@extends('backend.app')

@section('title', 'Edit Imported Data')

@section('main_menu', 'Excel Files')
@section('active_menu', 'Edit Imported Data')

@section('content')
    <div class="card">
        <div class="card-body" style="background-color: honeydew !important;">
            @if ($parameterGroups)
                <form method="post" action="{{ url('admin/save-supplier-spec-data') }}" id="editIndentExcelInput">
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
                        <table class="table table-border-vertical table-hover mb-3">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Parameter name</th>
                                    <th>Parameter value</th>
                                </tr>
                            </thead>
                            @php $slNo = 0; @endphp
                            @foreach ($parameterGroups as $groupName => $parameters)
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <input type="text" class="form-control bg-success"
                                                name="editedData[{{ $groupName }}][parameter_group_name]"
                                                value="{{ $groupName }}" disabled>
                                        </td>
                                    </tr>
                                    @foreach ($parameters as $parameter)
                                        <tr>
                                            <td class="col-md-1 py-1 text-center">{{ $slNo + 1 }}</td>
                                            <td class="col-md-4 py-1">
                                                <input type="text" class="form-control"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][parameter_name]"
                                                    value="{{ $parameter['parameter_name'] }}">
                                            </td>
                                            <td class="col-md-5 py-1">
                                                <input type="text" class="form-control"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][parameter_value]"
                                                    value="{{ $parameter['parameter_value'] }}">
                                            </td>
                                            <td class="col-md-2 py-1">
                                                <select class="form-control select2"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][remarks]">
                                                    <option value="Comply" selected>Comply</option>
                                                    <option value="Partially Comply">Partially Comply</option>
                                                    <option value="Non Comply">Non Comply</option>
                                                </select>
                                            </td>
                                        </tr>
                                        @php $slNo++; @endphp
                                    @endforeach
                                </tbody>
                            @endforeach
                        </table>
                    </div>

                    <div class="text-center">
                        <h4 class="bg-warning">Offer Remarks:</h4>
                        <select class="form-control select2" name="offer_remarks">
                            <option value="Responsive" selected>Responsive</option>
                            <option value="Non Responsive">Non Responsive</option>
                        </select>
                        <button type="submit" class="btn btn-success mt-3">Save Changes</button>
                    </div>
                </form>
            @else
                <p>No data imported.</p>
            @endif
        </div>
        <div class="card-footer py-3" style="background-color: teal !important;">
            <a href="{{ url('admin/import-supplier-spec-data-index') }}" class="btn btn-danger float-end">Cancel</a>
        </div>
    </div>
@endsection
