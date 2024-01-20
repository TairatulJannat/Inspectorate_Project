@extends('backend.app')

@section('title', 'Edit Imported Data')

@section('main_menu', 'Excel Files')
@section('active_menu', 'Edit Imported Data')

@section('content')
    <div class="card">
        <div class="card-body" style="background-color: honeydew !important;">
            @if ($parameterGroups)
                <form method="post" action="{{ url('admin/save-indent-spec-data') }}" id="editIndentExcelInput">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-12 d-flex justify-content-center align-items-center">
                            <div class="text-center">
                                <div class="item-id f-30">{{ $itemName }}</div>
                                <input type="hidden" name="item-id" value="{{ $itemId }}">
                                <div class="item-type-id f-28">{{ $itemTypeName }}</div>
                                <input type="hidden" name="item-type-id" value="{{ $itemTypeId }}">
                                <div class="indent-no f-20">Indent No: <span class="fw-bold">{{ $indentNo }}</span>
                                </div>
                                <input type="hidden" name="indent-no" value="{{ $indentNo }}">
                                <div class="indent-ref-no f-20">Indent Ref. No: <span
                                        class="fw-bold">{{ $indentRefNo }}</span>
                                </div>
                                <input type="hidden" name="indent-ref-no" value="{{ $indentRefNo }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <table class="table table-bordered table-hover mb-3">
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
                                        <td colspan="3">
                                            <input type="text" class="form-control bg-success"
                                                name="editedData[{{ $groupName }}][parameter_group_name]"
                                                value="{{ $groupName }}">
                                        </td>
                                    </tr>
                                    @foreach ($parameters as $parameter)
                                        <tr>
                                            <td class="col-md-1 py-1 text-center">{{ $slNo + 1 }}</td>
                                            <td class="col-md-5 py-1">
                                                <textarea class="form-control"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][parameter_name]">{{ $parameter['parameter_name'] }}</textarea>
                                            </td>
                                            <td class="col-md-6 py-1">
                                                <textarea class="form-control"
                                                    name="editedData[{{ $groupName }}][{{ $parameter['parameter_name'] }}][parameter_value]">{{ $parameter['parameter_value'] }}</textarea>
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
            <a href="{{ url('admin/import-indent-spec-data-index') }}" class="btn btn-danger float-end">Cancel</a>
        </div>
    </div>
@endsection
