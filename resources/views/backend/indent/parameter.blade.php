@extends('backend.app')
@section('title', 'Parameter')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/datatables.css') }}">
    <style>
        /* styles.css */

        /* Styling for the card elements */
        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #006A4E !important;
            border-radius: 8px 8px 0 0 !important;
            color: #ffff;
        }

        .card-body {

            margin: 30px 15px 30px 0
        }

        .table thead {
            background-color: #1B4C43 !important;
            border-radius: 10px !important;
        }

        .table thead tr th {
            color: #ffff !important;
        }

        .col-5 {
            padding: 10px 15px !important;
        }

        .col-4,
        .col-2 {
            background-color: #F5F7FB !important;
            /* Light gray */
            border-radius: 8px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        }

        h4 {
            margin-top: 0;
            color: #333;
        }

        /* Styling for the form elements */
        form {
            margin-top: 15px;
        }

        .delivery-btn {
            width: 100%;
            /* Adjust for padding */
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #ffffff !important;
            color: #006a4e8c;
            cursor: pointer;
        }

        .delivery-btn:hover {
            background-color: rgb(7, 66, 20), 59, 5) !important;
            /* Lighter orange on hover */
        }

        .forward_status {
            min-height: 250px
        }

        .remarks_status {
            min-height: 250px
        }

        .documents {
            display: flex;
            justify-content: center;
            column-gap: 10px;
            margin-bottom: 25px
        }
    </style>
@endpush
@section('main_menu', 'Parameter')
@section('active_menu', 'Details')
@section('content')
    <div class="col-sm-12 col-xl-12">
        <div class="card ">
            <div class="card-header">
                <h2>Details of Parameter</h2>
            </div>
            <div style="display: flex">
                <div class="card-body col-5">

                </div>

            </div>

        </div>
    </div>

@endsection
@push('js')
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/datatable/datatables/plugin/datatables.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script src="{{ asset('assets/backend/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/notify/bootstrap-notify.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var item_id = {{ $item_id }}
            var item_type_id = {{ $item_type_id }}

            // alert(item_type_id);
            $.ajax({
                url: "{{ url('admin/assign-parameter-value/show') }}",
                method: "POST",
                data: {
                    'item-id': item_id,
                    'item-type-id': item_type_id,
                },
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                success: function(response) {
                    if (response.isSuccess === false) {
                        console.log(response)

                    } else if (response.isSuccess === true) {


                        console.log(response)
                    }

                },
                error: function(error) {
                    console.log('Error:', error);

                },
            });

            function renderTreeView(treeViewData, itemTypeName, itemName) {
                var searchedDataContainer = $(".searched-data");

                searchedDataContainer.empty();

                if (treeViewData && treeViewData.length > 0) {
                    var html =
                        '<div class="p-md-3 paper-document" style="background-color: honeydew;">' +
                        '<div class="header text-center">' +
                        '<div class="item-id f-30">' + itemName + '</div>' +
                        '<div class="item-type-id f-20">' + itemTypeName + '</div>' +
                        '</div>' +
                        '<div class="content">';

                    $.each(treeViewData, function(index, node) {
                        html +=
                            '<div class="row parameter-group mt-5">' +
                            '<h5 class="parameter-group-name text-uppercase text-underline fw-bold">' + node
                            .parameterGroupName + '</h5>' +
                            '<table class="parameter-table table table-border-vertical table-hover">';

                        $.each(node.parameterValues, function(i, parameterValue) {
                            html +=
                                '<tr>' +
                                '<td class="col-md-4 parameter-name">' + parameterValue
                                .parameter_name +
                                '</td>' +
                                '<td class="col-md-8 parameter-value">' + parameterValue
                                .parameter_value +
                                '</td>' +
                                '</tr>';
                        });

                        html += '</table></div>';
                    });

                    html += '</div></div>';
                    searchedDataContainer.append(html);
                } else {
                    searchedDataContainer.html('<h2>Searched Item Parameters will appear here.</h2>');
                }
            }
        });
    </script>
@endpush
